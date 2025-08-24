<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\RbiVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Authentication routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password routes
Route::get('/forgot_password', function () {
    return view('auth.forgot_password');
})->name('password.request');

// Password reset routes
Route::get('/reset-password/{token?}', function ($token = null) {
    return view('auth.reset_password', [
        'token' => $token,
        'phone' => request()->query('phone'),
        'email' => request()->query('email'),
    ]);
})->name('password.reset');

use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'phone' => 'nullable|string|min:10|required_without:email',
        'email' => 'nullable|email|required_without:phone',
        'password' => 'required|confirmed|min:8',
    ]);

    try {
        // Find the user by provided identifier
        $user = null;
        if ($request->filled('phone')) {
            $user = User::where('phone', $request->phone)->first();
            if (!$user) {
                return back()->withErrors(['phone' => 'No account found with this phone number.'])->withInput();
            }
        } else if ($request->filled('email')) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
            }
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')
            ->with('status', 'Your password has been reset successfully! You can now log in with your new password.');
            
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'An error occurred while resetting your password. Please try again.'])->withInput();
    }
})->name('password.update');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/check-resident', [AuthController::class, 'checkResident']);


// Protected routes - require authentication
Route::middleware([App\Http\Middleware\Authenticate::class])->group(function () {
    // Home route
    Route::get('/home', function () {
        return view('hazard.home');
    })->name('home');

    // SuperAdmin routes
    Route::prefix('superadmin')->group(function () {
        Route::get('/manage_users', function () {
            return view('superadmin.manage_users');
        })->name('superadmin.manage_users');

        Route::post('/users/{id}/approve', function ($id) {
            return response()->json(['success' => true, 'message' => 'User account approved successfully!']);
        })->name('superadmin.approve_user');

        Route::post('/users/{id}/reject', function ($id) {
            return response()->json(['success' => true, 'message' => 'User account rejected successfully!']);
        })->name('superadmin.reject_user');

        Route::post('/users/{id}/suspend', function ($id) {
            return response()->json(['success' => true, 'message' => 'User account suspended successfully!']);
        })->name('superadmin.suspend_user');

        Route::post('/users/{id}/activate', function ($id) {
            return response()->json(['success' => true, 'message' => 'User account activated successfully!']);
        })->name('superadmin.activate_user');

        Route::delete('/users/{id}', function ($id) {
            return response()->json(['success' => true, 'message' => 'User account deleted successfully!']);
        })->name('superadmin.delete_user');
    });

    // Admin dashboard route
    Route::get('/admin/dashboard', function () {
        return view('hazard.home');
    })->name('admin.dashboard');
    
    Route::prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.disaster-maps');  // default page = disaster maps
    })->name('user.dashboard');

    Route::get('/disaster-maps', function () {
        return view('user.disaster-maps');
    })->name('disaster.maps');

    Route::get('/evacuation-centers', function () {
        return view('user.evacuation-centers');
    })->name('evacuation.centers');

    Route::get('/mou-homes', function () {
        return view('user.mou-homes');
    })->name('mou.homes');

    Route::get('/support-tickets', function () {
        return view('user.support-tickets');
    })->name('support.tickets');

    Route::get('/notifications', function () {
        return view('user.notifications');
    })->name('notifications');
});

    // Profile routes
    Route::get('/profile', function () {
        $fakeUser = (object)[
            'full_name' => session('full_name', 'Admin User'),
            'position' => session('position', 'Administrator'),
            'contact_number' => session('contact_number', '09123456789'),
            'photo' => session('photo', null),
            'email' => 'admin@gmail.com'
        ];
        $edit = request('edit', false);
        return view('hazard.manage_profile', ['fakeUser' => $fakeUser, 'edit' => $edit]);
    })->name('hazard.profile');

    Route::post('/profile', function (Request $request) {
        $photoPath = session('photo', null);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoPath = $file->store('profile_photos', 'public');
        }

        session([
            'full_name' => $request->input('full_name'),
            'position' => $request->input('position'),
            'contact_number' => $request->input('contact_number'),
            'photo' => $photoPath,
        ]);
        return redirect()->route('hazard.profile')->with('success', 'Profile updated!');
    })->name('profile.update');

    // Barangay routes
    Route::get('/ilawod', function () {
        return view('hazard.ilawod-demographic');
    })->name('barangay.ilawod');

    Route::post('/ilawod/export', function () {
        $data = [
            ['Purok', 'Population', 'Families'],
            ['Purok 1', 473, 142],
            ['Purok 2', 693, 208],
            ['Purok 3', 700, 210],
            ['Purok 4', 645, 194],
            ['Purok 5', 339, 99]
        ];
        
        $filename = 'ilawod_data.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    })->name('ilawod.export');

    Route::get('/sua', function () {
        return view('hazard.sua');
    })->name('barangay.sua');

    Route::get('/barangay1', function () {
        return view('hazard.barangay1');
    })->name('barangay.barangay1');

    Route::get('/barangay2', function () {
        return view('hazard.barangay2');
    })->name('barangay.barangay2');

    Route::get('/barangay3', function () {
        return view('hazard.barangay3');
    })->name('barangay.barangay3');
}); // End of auth middleware group

use App\Http\Controllers\ResidentController;

Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
Route::put('/residents/{resident}', [ResidentController::class, 'update'])->name('residents.update');
Route::delete('/residents/{resident}', [ResidentController::class, 'destroy'])->name('residents.destroy');
Route::resource('residents', ResidentController::class);


use App\Http\Controllers\EmergencyContactController;

// Routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Show all contacts
    Route::get('/contacts', [EmergencyContactController::class, 'index'])->name('contacts');

    // Store new contact
    Route::post('/contacts', [EmergencyContactController::class, 'store'])->name('contacts.store');

    // Edit contact (returns JSON)
    Route::get('/contacts/{id}/edit', [EmergencyContactController::class, 'edit'])->name('contacts.edit');

    // Update contact
    Route::put('/contacts/{id}', [EmergencyContactController::class, 'update'])->name('contacts.update');

    // Delete contact
    Route::delete('/contacts/{id}', [EmergencyContactController::class, 'destroy'])->name('contacts.destroy');
});

Route::get('/sms', function () {
    return view('hazard.sms');
})->name('sms');

Route::get('/evacuation', function () {
    return view('hazard.evacuation');
})->name('evacuation');

use App\Http\Controllers\MouHomeController;

// User: submit MOU
Route::get('/mou-homes', [MouHomeController::class,'create'])->name('mou.create');
Route::post('/mou-homes', [MouHomeController::class,'store'])->name('mou.store');

// Admin: view submissions
Route::get('/hazard/mou-homes', [MouHomeController::class,'index'])->name('hazard.mou.index');
Route::post('/hazard/mou-homes/{mouHome}/status', [MouHomeController::class,'updateStatus'])->name('hazard.mou.updateStatus');

// User submits MOU/MOA application
Route::post('/mou-homes/store', [App\Http\Controllers\MouHomeController::class, 'store'])->name('user.mou.store');

// Admin view MOU/MOA applications
Route::get('/hazard/mou-homes', [App\Http\Controllers\MouHomeController::class, 'index'])->name('hazard.mou.index');

// Update status
Route::post('/hazard/mou-homes/{mou}/update-status', [App\Http\Controllers\MouHomeController::class, 'updateStatus'])->name('hazard.mou.updateStatus');

// Update MOU/MOA application status
Route::post('/hazard/mou/update-status/{mouHome}', [MouHomeController::class, 'updateStatus'])
    ->name('hazard.mou.updateStatus');
