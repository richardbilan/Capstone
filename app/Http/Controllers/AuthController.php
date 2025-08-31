<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Resident;
use App\Models\User;

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
            'rbi_no' => 'required|string',
            'password' => 'required|string',
        ]);

        // Authenticate by rbi_no + password
        $user = User::where('rbi_no', $request->input('rbi_no'))->first();
        if ($user && \Illuminate\Support\Facades\Hash::check($request->input('password'), $user->password)) {
            auth()->login($user);

            // Set session variable for authentication
            session(['authenticated' => true]);

            // Store user data in session
            session([
                'user_id' => $user->id,
                'full_name' => $user->first_name . ' ' . $user->last_name,
                'role' => $user->role
            ]);

            // Redirect based on role
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.manage_users');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->withErrors(['Invalid RBI number or password.'])->withInput($request->only('rbi_no'));
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
        // Validate request per new requirements
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female,Other',
            'birthday' => 'required|date',
            'purok' => 'required|string|max:50',
            'rbi_no' => 'required|string|max:60',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Enforce Ilawod-only at backend
        $barangay = 'Ilawod';

        // Normalize input for matching
        $fn = strtolower(trim($validated['first_name']));
        $mn = strtolower(trim($validated['middle_name'] ?? ''));
        $ln = strtolower(trim($validated['last_name']));
        $sf = strtolower(trim($validated['suffix'] ?? ''));
        $bday = date('Y-m-d', strtotime($validated['birthday']));

        // Block if RBI number already registered
        $existingByRbi = User::whereRaw('LOWER(rbi_no)=?', [strtolower($validated['rbi_no'])])->first();
        if ($existingByRbi) {
            return response()->json([
                'message' => 'This RBI number is already registered. Please log in or reset your password.'
            ], 409);
        }

        // Check if such user already exists in users to avoid duplicates (same identity)
        $dupeUser = User::whereRaw('LOWER(first_name)=?', [$fn])
            ->whereRaw('LOWER(IFNULL(middle_name, ""))=?', [$mn])
            ->whereRaw('LOWER(last_name)=?', [$ln])
            ->whereRaw('LOWER(IFNULL(suffix, ""))=?', [$sf])
            ->whereDate('birthday', $bday)
            ->first();
        if ($dupeUser) {
            return response()->json([
                'message' => 'This resident is already registered. Please log in or reset your password.'
            ], 409);
        }

        // Match against residents masterlist (name + birthday)
        $residentQuery = Resident::query()
            ->whereRaw('LOWER(firstname)=?', [$fn])
            ->whereRaw('LOWER(IFNULL(middlename, ""))=?', [$mn])
            ->whereRaw('LOWER(surname)=?', [$ln])
            ->whereRaw('LOWER(IFNULL(suffix, ""))=?', [$sf])
            ->whereDate('birthday', $bday)
            ->whereRaw('LOWER(rbi_no)=?', [strtolower($validated['rbi_no'])]);

        $resident = $residentQuery->first();

        if (!$resident) {
            return response()->json([
                'message' => 'Registration denied: No matching Ilawod resident found for the provided name and birthday.'
            ], 422);
        }

        // Create user record
        $user = new User();
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'] ?? null;
        $user->last_name = $validated['last_name'];
        $user->suffix = $validated['suffix'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->email = $validated['email'] ?? null;
        $user->barangay = $barangay; // force Ilawod
        $user->purok = $validated['purok'];
        $user->birthday = $bday;
        $user->age = $validated['age'];
        $user->gender = $validated['gender'];
        // Important: DB column is rbi_no (not rib_no)
        $user->rbi_no = $validated['rbi_no'];
        $user->password = Hash::make($validated['password']);
        $user->role = 'user';
        $user->is_resident = 1;

        try {
            $user->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $msg = 'Registration failed. Please check your details and try again.';
            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, 'users_phone_unique')) {
                $msg = 'This phone number is already registered. Use a different number or log in.';
            } elseif (str_contains($errorMessage, 'users_email_unique')) {
                $msg = 'This email is already registered. Use a different email or log in.';
            } elseif (str_contains($errorMessage, 'Unknown column')) {
                $msg = 'A server configuration error occurred. Please contact support.';
            }
            return response()->json(['message' => $msg], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registration successful. You may now log in.'
        ], 201);
    }

    /**
     * AJAX endpoint to check if a resident with the given name and rib_no exists and is not yet registered.
     */
    public function checkResident(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'suffix' => 'nullable|string',
            'birthday' => 'required|date',
            'rbi_no' => 'required|string',
        ]);

        $fn = strtolower(trim($request->input('first_name')));
        $mn = strtolower(trim($request->input('middle_name', '')));
        $ln = strtolower(trim($request->input('last_name')));
        $sf = strtolower(trim($request->input('suffix', '')));
        $bday = date('Y-m-d', strtotime($request->input('birthday')));

        $resident = Resident::whereRaw('LOWER(firstname)=?', [$fn])
            ->whereRaw('LOWER(IFNULL(middlename, ""))=?', [$mn])
            ->whereRaw('LOWER(surname)=?', [$ln])
            ->whereRaw('LOWER(IFNULL(suffix, ""))=?', [$sf])
            ->whereDate('birthday', $bday)
            ->whereRaw('LOWER(rbi_no)=?', [strtolower($request->input('rbi_no'))])
            ->first();

        if (!$resident) {
            return response()->json(['exists' => false, 'message' => 'No matching resident found.'], 404);
        }

        $already = User::whereRaw('LOWER(first_name)=?', [$fn])
            ->whereRaw('LOWER(IFNULL(middle_name, ""))=?', [$mn])
            ->whereRaw('LOWER(last_name)=?', [$ln])
            ->whereRaw('LOWER(IFNULL(suffix, ""))=?', [$sf])
            ->whereDate('birthday', $bday)
            ->exists();

        // Also check by RBI number alone
        $alreadyByRbi = User::whereRaw('LOWER(rbi_no)=?', [strtolower($request->input('rbi_no'))])->exists();

        if ($already || $alreadyByRbi) {
            return response()->json(['exists' => true, 'registered' => true, 'message' => 'This resident is already registered.'], 200);
        }

        return response()->json(['exists' => true, 'registered' => false, 'message' => 'Resident found and can register.'], 200);
    }
}