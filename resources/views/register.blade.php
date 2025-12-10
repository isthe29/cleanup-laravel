<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Beach & Ocean Clean-up Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">Create an Account</h3>

                    <!-- Error message -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


                    <form method="POST" action="/register">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required>

                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>

                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- Register as -->
                        <div class="mb-3">
                            <label class="form-label">Register As</label>

                            <select name="registered_as"
                                    id="registered_as"
                                    class="form-select @error('registered_as') is-invalid @enderror"
                                    required
                                    onchange="toggleOrgName()">

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

                            <input type="text"
                                   name="org_name"
                                   class="form-control @error('org_name') is-invalid @enderror"
                                   value="{{ old('org_name') }}">

                            @error('org_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                              class="form-check-input"
                              name="remember"
                              id="remember"
                              {{ old('remember') ? 'checked' : '' }}>
                          <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <!-- Submit button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>

                        <div class="text-center">
                            <small>Already have an account?
                                <a href="/login">Login</a></small>
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
        document.getElementById('org_name_div').style.display =
            role === 'Organizer' ? 'block' : 'none';
    }

    // Keep state after validation
    toggleOrgName();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
