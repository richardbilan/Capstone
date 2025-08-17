<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'password' => 'required',
    ]);

    $credentials = [
        'phone' => $request->input('phone'),
        'password' => $request->input('password'),
    ];

    if (auth()->attempt($credentials)) {
        // Set session variable for authentication
        session(['authenticated' => true]);
        
        // Store user data in session
        $user = auth()->user();
        session([
            'user_id' => $user->id,
            'full_name' => $user->first_name . ' ' . $user->last_name,
            'role' => $user->role
        ]);
        
        // Authentication passed, redirect based on role
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.manage_users');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    return redirect()->back()->withErrors(['Invalid phone number or password.']);
}

    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear auth session
        auth()->logout();
        
        // Redirect to login page with success message
        return redirect()->route('login')->with('status', 'You have been successfully logged out.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'contact' => 'required',
            'rib_no' => 'required',
            'password' => 'required|confirmed',
        ]);

        // Normalize input: trim, lowercase, single space
        $rib_no = strtolower(trim($request->input('rib_no')));
        $first_name = strtolower(trim(preg_replace('/\s+/', ' ', $request->input('first_name'))));
        $middle_name = strtolower(trim(preg_replace('/\s+/', ' ', $request->input('middle_name'))));
        $last_name = strtolower(trim(preg_replace('/\s+/', ' ', $request->input('last_name'))));

        // Case-insensitive match by rib_no AND full name
        $resident = \App\Models\User::whereRaw('LOWER(TRIM(rib_no)) = ?', [$rib_no])
            ->whereRaw('LOWER(TRIM(first_name)) = ?', [$first_name])
            ->whereRaw('LOWER(TRIM(middle_name)) = ?', [$middle_name])
            ->whereRaw('LOWER(TRIM(last_name)) = ?', [$last_name])
            ->first();

        if (!$resident) {
            return redirect()->back()->withErrors(['rib_no' => 'Resident not found. Please make sure your RBI number and full name match our records.'])->withInput();
        }

        // Check if this resident is already registered (has a phone set)
        if (!empty($resident->phone)) {
            return redirect()->back()->withErrors(['rib_no' => 'This resident is already registered.'])->withInput();
        }

        // Update resident record with registration info
        $resident->age = $request->input('age');
        $resident->gender = $request->input('gender');
        $resident->phone = $request->input('contact');
        $resident->password = bcrypt($request->input('password'));
        $resident->save();

        // Registration complete, redirect to login page with success message
        return redirect()->route('login')->with('success', 'Registration complete! You can now log in with your new credentials.');
    }

    /**
     * AJAX endpoint to check if a resident with the given name and rib_no exists and is not yet registered.
     */
    public function checkResident(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'rib_no' => 'required',
        ]);

        $resident = \App\Models\User::whereRaw('LOWER(rib_no) = ?', [strtolower($request->input('rib_no'))])
            ->whereRaw('LOWER(first_name) = ?', [strtolower($request->input('first_name'))])
            ->whereRaw('LOWER(middle_name) = ?', [strtolower($request->input('middle_name'))])
            ->whereRaw('LOWER(last_name) = ?', [strtolower($request->input('last_name'))])
            ->first();

        if (!$resident) {
            return response()->json(['exists' => false, 'message' => 'No matching resident found.'], 404);
        }
        if (!empty($resident->phone)) {
            return response()->json(['exists' => true, 'registered' => true, 'message' => 'This resident is already registered.'], 200);
        }
        return response()->json(['exists' => true, 'registered' => false, 'message' => 'Resident found and can register.'], 200);
    }
}