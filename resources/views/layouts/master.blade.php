{{-- resources/views/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>
    @hasSection('title')
        @yield('title') | Beach & Ocean Clean-up Hub
    @else
        Beach & Ocean Clean-up Hub
    @endif
  </title>


  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo_sm.png') }}">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <style>
    body { background: #252525; scroll-behavior: smooth; }
    .body-container { background: linear-gradient(to bottom, rgba(13, 110, 253, 1) 0%, rgba(0, 161, 230, 0.69) 50%, rgba(117, 211, 255, 0.45) 100%); border-radius: 10px; margin-top: 5px; margin-bottom: 5px;}
    .nav-link.active { font-weight: bold; }
    .navbar-blur { border-radius: 10px;}
    .card { box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
    .search-box { max-width: 300px; }
    .hub-section, .about-section { text-align: center; padding: 20px 40px; }
    .hub-section h1, .about-section h1 { font-size: 2.5rem; font-weight: 700; color: #0d6efd; }
    .hub-section p, .about-section p { font-size: 1.2rem; max-width: 700px; margin: 20px auto 0; }
    .dashboard-title { font-size: 2rem; font-weight: 700; color: #0d6efd; }
    /* .proponents-names { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-top: 1rem; }
    .proponent-badge { font-size: 1.1rem; padding: 12px 20px; }  */
    .override-color-white{ color: white !important;}
    .div-radius-items{ border-radius: 24px; background-color: #303034; margin-top: 20px;}
    .navbar-wrapper { max-width: 1885px; margin: 10px auto 0 auto; padding: 0 20px; }
    .modal-login { border-radius: 20px; background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); color: #ffffff; opacity: 0.95; }
    .form-label, .form-check-label { color: #fff; }
    body.modal-open { padding-right: 0 !important; }
    .navbar { transition: margin-right 0s; }
  </style>

  @stack('styles') {{-- optional for page-specific styles --}}
</head>
<body>

  <!-- Navbar -->
  <div class="navbar-wrapper sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-blur">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('images/logo_sm.png')}}" alt="Logo" class="rounded-pill logo" style="margin-left: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link @if(request()->is('/')) active @endif" href="{{ route() }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link @if(request()->is('about')) active @endif" href="{{ route() }}">About Us</a></li>
            <li class="nav-item"><a class="nav-link @if(request()->is('events')) active @endif" href="{{ route() }}">Events</a></li>
          </ul>
          <div class="d-flex">
            <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-outline-light btn-sm" onclick="window.location.href='{{ url('/signup') }}'">Sign Up</button>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <main>
    @yield('content') {{-- page-specific content --}}
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
            <li><a href="#hub" class="text-light text-decoration-none">Home</a></li>
            <li><a href="#about" class="text-light text-decoration-none">About Us</a></li>
            <li><a href="#help" class="text-light text-decoration-none">How You Can Help</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.3);">
      © 2025 Beach & Ocean Clean-Up Hub | School Project – All Rights Reserved
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

  </script>
  @stack('scripts') {{-- page-specific scripts --}}
</body>
</html>
