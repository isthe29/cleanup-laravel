<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Organizer;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\MassAssignmentException;


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
                'nullable',
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
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     logger()->error("VALIDATION ERROR", $e->errors());
        // }
        // Return validation errors for each field
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // This attaches errors to the correct fields
                ->withInput();
        }

       DB::beginTransaction();

try {
    try {
    $user = User::create([
        'usr_name' => $request->name,
        'password' => Hash::make($request->password),
        'registered_as' => $request->registered_as,
    ]);
} catch (\Exception $e) {
    dd($e->getMessage(), $e->getTraceAsString());
}
    // Create UserDetail
    UserDetail::create([
        'usr_id' => $user->usr_id,
        'email_add' => $request->email,
    ]);

    // If Organizer
    if ($request->registered_as === 'Organizer') {
        $orgName = ucwords(strtolower($request->org_name));
        Organizer::create([
            'org_id' => $user->usr_id,
            'org_name' => $orgName,
        ]);
    }

    if ($request->registered_as === 'Volunteer') {
        Volunteer::create([
            'vol_id' => $user->usr_id,
        ]);
    }

    DB::commit();


} catch (QueryException $e) {
    DB::rollBack();

    // Detect missing column, constraint failure, or invalid SQL
    if (str_contains($e->getMessage(), 'Unknown column')) {
        $message = 'A required database column is missing. Please contact support.';
    } else {
        $message = 'Registration failed due to a database error.';
    }

    Log::error('SQL ERROR DURING REGISTRATION', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    return redirect()->back()
        ->with('error', $message)
        ->withInput();


} catch (MassAssignmentException $e) {
    DB::rollBack();

    Log::error('MASS ASSIGNMENT ERROR', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    return redirect()->back()
        ->with('error', 'A required field is blocked from being saved. Please notify support.')
        ->withInput();


} catch (\Exception $e) {
    DB::rollBack();

    Log::error('GENERAL ERROR DURING REGISTRATION', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);

    return redirect()->back()
        ->with('error', 'Registration failed unexpectedly.')
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
            ? redirect()->route('dashboard.organizer')->with('success', 'Registration successful! Welcome, Organizer.')
            : redirect()->route('dashboard.volunteer')->with('success', 'Registration successful! Welcome, Volunteer.');
    }
}
