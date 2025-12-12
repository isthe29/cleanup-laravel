<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('login');
    }

    // Process login
    public function login(Request $request)
    {
        // 1️⃣ Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        // 2️⃣ Find user via Eloquent relationship
        $user = User::whereHas('details', function ($query) use ($request) {
            $query->where('email_add', $request->email);
        })->with('details')->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
        }

        // 3️⃣ Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        // 4️⃣ Log the user in
        Auth::login($user);

        // 5️⃣ Handle Remember Me
        if ($request->has('remember')) {
            $rawToken = Str::random(60);                // Cookie value
            $hashedToken = hash('sha256', $rawToken);  // Store hashed in DB

            $user->remember_token = $hashedToken;
            $user->save();

            Cookie::queue('remember_me', $rawToken, 60 * 24 * 30); // 30 days
        }

        // 6️⃣ Redirect based on role with success message
        $redirectRoute = $user->registered_as === 'Organizer'
            ? '/dashboard/organizer'
            : '/dashboard/volunteer';

        return redirect($redirectRoute)->with('success', 'Welcome back!');
    }

    // Logout
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->remember_token = null;
            $user->save();
        }

        Cookie::queue(Cookie::forget('remember_me'));
        Auth::logout();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
