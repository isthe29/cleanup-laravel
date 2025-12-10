<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->registered_as === 'Volunteer') {
            return redirect('/dashboard/volunteer');
        }

        if ($user->registered_as === 'Organizer') {
            return redirect('/dashboard/organizer');
        }

        // fallback
        abort(403, 'Unauthorized.');
    }
}
