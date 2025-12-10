<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('login'); // login.blade.php
    }

    // Process login
    public function login(Request $request)
    {
        // 1️⃣ Validate input with custom messages
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        // 2️⃣ Find user by email
        $user = User::where('email', $request->email)->first();

        // 3️⃣ Check if user exists and password matches
        if (!$user) {
            // Attach error specifically to the email field
            return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            // Attach error specifically to the password field
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        // 4️⃣ Store user in session
        session(['user' => $user]);

        // 5️⃣ Handle "Remember Me"
        if ($request->has('remember')) {
            $token = Str::random(60);

            // Save the token in the database (remember_token column needed)
            $user->remember_token = $token;
            $user->save();

            // Store token in cookie, expires in 30 days
            Cookie::queue('remember_me', $token, 60 * 24 * 30); // minutes
        }

        // 6️⃣ Redirect based on user role
        if ($user->registered_as === 'Volunteer') {
            return redirect('/dashboard/volunteer');
        }

        if ($user->registered_as === 'Organizer') {
            return redirect('/dashboard/organizer');
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        if ($user = session('user')) {
            $user->remember_token = null;
            $user->save();
        }

        session()->forget('user');
        Cookie::queue(Cookie::forget('remember_me'));

        return redirect('/login');
    }
}
 