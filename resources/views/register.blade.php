<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Beach & Ocean Clean-up Hub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Figtree Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
        }
        .btn-primary-custom {
            background-color: #3b82f6; /* Tailwind blue */
            border-color: #3b82f6;
            color: #fff;
        }
        .btn-primary-custom:hover {
            background-color: #2563eb; /* Tailwind blue hover */
            border-color: #2563eb;
            color: #fff;
        }
        .form-label {
            font-weight: 500;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            
        }
        .site-name {
            font-weight: 600;
            font-size: 1.25rem;
            margin-top: 0.5rem;
            color: #111827;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">
            
            <!-- Logo and Website Name -->
            <div class="logo-container">
                <img src="{{ asset('images/logo_full.png') }}" alt="Logo">
                <div class="site-name">Beach & Ocean Clean-up Hub</div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">Create an Account</h3>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="/register">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- Register As -->
                        <div class="mb-3">
                            <label class="form-label">Register As</label>
                            <select name="registered_as" id="registered_as" class="form-select @error('registered_as') is-invalid @enderror" required onchange="toggleOrgName()">
                                <option value="">Select Role</option>
                                <option value="Volunteer" {{ old('registered_as') == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                                <option value="Organizer" {{ old('registered_as') == 'Organizer' ? 'selected' : '' }}>Organizer</option>
                            </select>
                            @error('registered_as')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Organization Name -->
                        <div class="mb-3" id="org_name_div" style="display: none;">
                            <label class="form-label">Organization Name</label>
                            <input type="text" name="org_name" class="form-control @error('org_name') is-invalid @enderror" value="{{ old('org_name') }}">
                            @error('org_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary-custom">Register</button>
                        </div>

                        <div class="text-center">
                            <small>Already have an account? <a href="/login">Login</a></small>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function toggleOrgName() {
        const role = document.getElementById('registered_as').value;
        document.getElementById('org_name_div').style.display = role === 'Organizer' ? 'block' : 'none';
    }

    toggleOrgName();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
