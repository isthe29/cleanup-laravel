<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CreateEventController;
use App\Http\Controllers\VolunteerController;

// Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// Register
Route::get('/register', function () {
    return view('register'); })->name('register');
Route::post('/register', [RegisterController::class,'register'])->name('register.process');

// Home page
Route::get('/', function () {
    return view('index'); // resources/views/index.blade.php
})->name('index');

Route::get('/about', function () {
    if(auth()->check()) {
        return view('dashboard.about'); // show dashboard content
    } else {
        return view('about'); // guest content
    }
})->name('about');

Route::get('/verify-pending/{token}', [RegisterController::class, 'verifyEmail'])->name('pending.verify');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard/organizer', [OrganizerController::class, 'dashboard'])
        ->name('dashboard.organizer');
    Route::get('/dashboard/volunteer', [VolunteerController::class, 'index'])->name('volunteer.dashboard');
    Route::post('/volunteer/join-event/{id}', [VolunteerController::class, 'joinEvent'])->name('volunteer.joinEvent');
    
    Route::get('/organizer/create-event', [CreateEventController::class, 'showCreateEvent'])
        ->name('organizer.createEventForm');

    Route::post('/organizer/create-event', [CreateEventController::class, 'createEvent'])
        ->name('organizer.createEvent');

    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/search', [EventController::class, 'search'])->name('events.search');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});




