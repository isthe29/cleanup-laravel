<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sign Up | Beach & Ocean Clean-up Hub</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body { background: #252525;opacity: 0.95;}
    .signup-container { min-height: 100vh; }
    .card { border-radius: 20px; background: linear-gradient(135deg, #005f73 0%, #0a9396 100%); color: #ffffff; opacity: 0.95;}
    .modal-login {border-radius: 20px; background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); color: #ffffff; opacity: 0.95;}
    .form-label , .form-check-label { color: #ffff;}
    .navbar { background: #2e2e2eff;}
    a {color: #1e3c72;}
    .btn-signup {color: #ffff; border-color: #ffff;}
    .btn-signup:hover {color: #000; background: #ffff;}
    .toggle-password-btn { position: absolute; top: 50%; right: 12px; transform: translateY(-50%); border: none; background: transparent; padding: 0; margin: 0; cursor: pointer; color: #6c757d; font-size: 1.05rem; line-height: 1; display: inline-flex; align-items: center; justify-content: center;}
    .form-control.pe-for-icon { padding-right: 3rem; }
    .btn-terms:hover {background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%); color: #ffffff;}
    .btn-terms {border-color: #000; color: #000;}
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar shadow-sm mb-2">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/" style="text-decoration:none;">
      <img src="{{ asset('images/logo_sm.png') }}" class="rounded-pill me-2" style="width:50px;height:50px;">
      <h5 class="mb-0 text-white fw-bold">Beach & Ocean Clean-up Hub</h5>
    </a>
  </div>
</nav>

<!-- Signup Form -->
<div class="signup-container container d-flex align-items-center justify-content-center">
  <div class="row w-100">
    <div class="col-lg-6 mx-auto">
      <div class="card border-0 shadow p-5">

        <h1 class="text-center text-white mb-1 fw-bold">Create Your Account</h1>
        <p class="text-center text-white">
          Already have an account?
          <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</a>
        </p>

        <!-- LARAVEL CHANGE: Breeze register route -->
        <form action="{{ route('register') }}" method="POST" novalidate>
          @csrf

          <!-- Show Errors -->
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label text-white">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required value="{{ old('email') }}">
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="position-relative">
              <input type="password" name="password" id="password" class="form-control pe-for-icon" placeholder="Enter your password" required>
              <button type="button" class="toggle-password-btn" id="togglePasswordBtn">
                <i class="bi bi-eye-slash"></i>
              </button>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="position-relative">
              <input type="password" name="password_confirmation" id="confirmPassword" class="form-control pe-for-icon" placeholder="Re-enter your password" required>
              <button type="button" class="toggle-password-btn" id="toggleConfirmBtn">
                <i class="bi bi-eye-slash"></i>
              </button>
            </div>
          </div>

          <!-- Registering As -->
          <div class="mb-3">
            <label class="form-label">Register As:</label>
            <select name="registered_as" id="userType" class="form-select" required>
              <option value="" disabled selected>Select type</option>
              <option value="Volunteer" {{ old('registered_as') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
              <option value="Organizer" {{ old('registered_as') == 'organization' ? 'selected' : '' }}>Organization</option>
            </select>
          </div>

          <!-- Organization Name -->
          <div class="mb-3" id="orgNameGroup" style="display:none;">
            <label class="form-label">Organization Name</label>
            <input type="text" name="organization_name" id="organizationName" class="form-control" placeholder="Enter organization name" value="{{ old('organization_name') }}">
          </div>

          <!-- Terms -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms-consent" required>
            <label class="form-check-label small">
              I agree to the
              <a href="#" data-bs-toggle="modal" data-bs-target="#termsPrivacyModal">Terms of Use & Privacy Policy</a>
            </label>
          </div>

          <button type="submit" class="btn btn-signup w-100 mb-3">Sign Up</button>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow modal-login">
      <div class="modal-body p-5">
        <h1 class="text-center text-white mb-3 fw-bold">Log In</h1>
        <p class="text-center text-white mb-4">Welcome back!</p>

        <form action="{{ route('login') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="position-relative">
              <input type="password" name="password" id="password" class="form-control pe-for-icon" placeholder="Enter your password" required>
              <button type="button" class="toggle-password-btn" id="togglePasswordBtn">
                <i class="bi bi-eye-slash"></i>
              </button>
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>

          <button type="submit" class="btn btn-signup w-100 mb-3">Log In</button>
        </form>

        <p class="text-center mt-2">
          <a href="{{ route('password.request') }}" class="text-decoration-underline">
            Forgot your Password?
          </a>
        </p>

      </div>
    </div>
  </div>
</div>

<!-- Terms & Privacy Modal -->
<div class="modal fade" id="termsPrivacyModal" tabindex="-1" aria-labelledby="termsPrivacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content shadow-lg" style="border-radius: 10px;">
      <div class="modal-header bg-light border-bottom">
        <h5 class="modal-title fw-bold" id="termsPrivacyModalLabel">Terms of Use & Privacy Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #fdfdfd;">

        <!-- Document Container -->
        <div class="p-3 border rounded" style="background-color: #ffffff; max-height: 60vh; overflow-y: auto;">
          <h6 class="fw-bold mb-2">1. Introduction</h6>
          <p class="text-muted small">
            Welcome to <strong>Beach and Ocean Clean-up Hub</strong>. By creating an account or participating in our programs, 
            you agree to abide by the terms stated below. Please read this document carefully.
          </p>

          <h6 class="fw-bold mt-4 mb-2">2. Terms of Use</h6>
          <p class="text-muted small">
            You agree to use our platform responsibly and only for its intended purposes. 
            Organizers and volunteers must provide accurate information and follow community guidelines.
          </p>
          <ul class="text-muted small">
            <li>Respect event rules and organizers’ instructions.</li>
            <li>Do not share your account credentials with others.</li>
            <li>Use respectful language and behavior at all times.</li>
          </ul>

          <h6 class="fw-bold mt-4 mb-2">3. Privacy Policy</h6>
          <p class="text-muted small">
            Your privacy is important to us. We collect minimal information needed to provide our services, such as 
            your name, contact details, and participation history.
          </p>
          <p class="text-muted small">
            We do not sell or share your data with third parties except as required by law or to facilitate events you join.
          </p>

          <h6 class="fw-bold mt-4 mb-2">4. Data Usage</h6>
          <p class="text-muted small">
            We use your data to improve our programs, generate analytics, and communicate with you regarding 
            clean-up activities and related events.
          </p>

          <h6 class="fw-bold mt-4 mb-2">5. Agreement</h6>
          <p class="text-muted small">
            By continuing to use our services, you agree to these Terms and our Privacy Policy.
            If you do not agree, you should discontinue using our platform.
          </p>
        </div>

      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-terms" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



  <script>
    // Toggle password for main password field
    document.getElementById('togglePasswordBtn').addEventListener('click', function () {
      const input = document.getElementById('password');
      const icon = this.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
        this.setAttribute('aria-pressed', 'true');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
        this.setAttribute('aria-pressed', 'false');
      }
      input.focus(); // keep focus in the input after toggling
    });

    // Toggle confirm password
    document.getElementById('toggleConfirmBtn').addEventListener('click', function () {
      const input = document.getElementById('confirmPassword');
      const icon = this.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
        this.setAttribute('aria-pressed', 'true');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
        this.setAttribute('aria-pressed', 'false');
      }
      input.focus();
    });
    // Login show password checkbox
  const showLoginPasswordCheck = document.getElementById('showLoginPasswordCheck');
  const loginPasswordField = document.getElementById('loginPassword');

  showLoginPasswordCheck.addEventListener('change', () => {
    loginPasswordField.type = showLoginPasswordCheck.checked ? 'text' : 'password';
  });

    // Show/hide organization name field based on user type
    document.getElementById('userType').addEventListener('change', function () {
      document.getElementById('orgNameGroup').style.display = (this.value === 'organization') ? 'block' : 'none';
    });
  </script>
</body>
</html>
