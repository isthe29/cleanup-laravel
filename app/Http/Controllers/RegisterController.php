<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class RegisterController extends Controller
{
    // Show the registration form
    public function showForm()
    {
        return view('register'); // Your Blade file
    }

    // Handle registration submission
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_details,email_add',
            'password' => 'required|confirmed|min:8',
            'registered_as' => 'required|in:Volunteer,Organizer',
            'org_name' => [
                'required_if:registered_as,Organizer',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\s\.\'\-&]+$/',
                'not_regex:/^[0-9]+$/',
            ],
        ], [
            // Field-specific error messages
            'name.required' => 'Please enter your name.',
            'name.string' => 'Name must be valid.',
            'name.max' => 'Name cannot exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email already exists.',

            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',

            'org_name.required_if' => 'Organization name is required when registering as an Organizer.',
            'org_name.string' => 'Organization name must be valid.',
            'org_name.max' => 'Organization name cannot exceed 255 characters.',
            'org_name.regex' => 'Organization name can only contain letters, numbers, spaces, periods, apostrophes, hyphens, and ampersands.',
            'org_name.not_regex' => 'Organization name cannot be only numbers.',
        ]);

        // Return validation errors for each field
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // This attaches errors to the correct fields
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'usr_name' => $request->name,
                'password' => Hash::make($request->password),
                'registered_as' => $request->registered_as,
            ]);

            // Create UserDetail
            UserDetail::create([
                'usr_id' => $user->usr_id,
                'email_add' => $request->email,
            ]);

            // If Organizer, create organizer row
            if ($request->registered_as === 'Organizer') {
                $orgName = ucwords(strtolower($request->org_name));
                Organizer::create([
                    'org_id' => $user->usr_id,
                    'org_name' => $orgName,
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }

        // 🔹 Automatically log in the user
        Auth::login($user);

        // 🔹 Handle Remember Me cookie if checked
        if ($request->has('remember')) {
            $token = Str::random(60);
            $user->remember_token = $token;
            $user->save();
            Cookie::queue('remember_me', $token, 60 * 24 * 30); // 30 days
        }

        // Redirect based on role
        return $user->registered_as === 'Organizer'
            ? redirect()->route('dashboard.organizer')
            : redirect()->route('dashboard.volunteer');
    }
}
