<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
            @yield('title') | Beach & Ocean Clean-up Hub
        @else
            Beach & Ocean Clean-up Hub
        @endif
    </title>

    @php
        $dashboardRoute = null;
        if(Auth::check()) {
            $dashboardRoute = Auth::user()->registered_as === 'Organizer'
                ? route('dashboard.organizer')
                : route('dashboard.volunteer');
        }
    @endphp

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo_sm.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        body { background: #252525; font-family: 'Figtree', sans-serif; scroll-behavior: smooth; }
        .navbar-blur { border-radius: 10px; }
        .profile-btn { background: none; border: none; color: #fff; font-weight: 600; padding: 6px 12px; font-size: 0.95rem; transition: color .2s ease; }
        .profile-btn:hover { color: #dbeafe; }
        .profile-menu { width: 280px; padding: 0; background-color: #161b22; border: 1px solid #30363d; border-radius: 10px; animation: fadeSlide .15s ease-out; }
        .profile-header { padding: 15px; border-bottom: 1px solid #30363d; }
        .profile-header h5 { margin: 0; font-size: 1rem; font-weight: 600; color: #c9d1d9; }
        .profile-header p { margin: 2px 0; color: #8b949e; font-size: 0.85rem; }
        .profile-menu .dropdown-item { padding: 10px 15px; font-size: 0.9rem; color: #c9d1d9; }
        .profile-menu .dropdown-item:hover { background-color: #30363d; color: #fff; }
        .dropdown-menu { z-index: 1055; }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <div class="navbar-wrapper sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-blur">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ $dashboardRoute }}">
                    <img src="{{ asset('images/logo_sm.png')}}" alt="Logo" class="rounded-pill logo" style="margin-left: 10px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link @yield('dashboard') @if(request()->is('dashboard/*')) active @endif" href="{{ $dashboardRoute }}">
                                    Dashboard
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('about')) active @endif" href="{{ route('about') }}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('events') @if(request()->is('events*')) active @endif" href="{{ route('events.index') }}">Events</a>
                        </li>
                    </ul>

                    <div class="d-flex">
                        @auth
                        <div class="dropdown">
                            <button class="btn profile-btn d-flex align-items-center" type="button" id="profileDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-check me-2" style="font-size: 1.3rem;"></i>
                                {{ Auth::user()->name }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdownButton">
                                <li class="profile-header">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p class="mb-0">{{ Auth::user()->role ?? 'User' }}</p>
                                    <p class="mb-0">Email: {{ Auth::user()->email }}</p>
                                    <p class="mb-0">Contact: {{ Auth::user()->contact ?? 'N/A' }}</p>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">Sign out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-lg-start text-light" style="background-color: #1c1c1c; margin-top: 40px; border-radius: 10px 10px 0 0;">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="fw-bold text-info">Beach & Ocean Clean-Up Hub</h5>
                    <p>Together, we can protect our oceans and preserve our beaches. Join our movement to create cleaner, safer, and healthier coastlines.</p>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="fw-bold text-info">Quick Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ $dashboardRoute }}" class="text-light text-decoration-none">Dashboard</a></li>
                        <li><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-light text-decoration-none">Events</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.3);">
            © 2025 Beach & Ocean Clean-Up Hub | School Project – All Rights Reserved
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
