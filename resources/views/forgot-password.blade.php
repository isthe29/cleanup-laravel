@extends('layouts.guest')

@section('content')

<div class="forgot-container mx-auto mt-5 p-4 bg-white shadow rounded" style="max-width: 450px;">

    <p class="text-muted mb-4">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </p>

    <!-- SESSION STATUS -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- EMAIL -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>

            <input 
                type="email" 
                name="email" 
                id="email"
                value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required autofocus
            >

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Email Password Reset Link
            </button>
        </div>

    </form>
</div>

@endsection
