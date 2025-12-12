@extends('layouts.logged')

@section ('title', 'Organizer Dashboard')

@section ('dashboard', 'active')

@push('styles')
<style>
    .card {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.12);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

/* Hover zoom effect */
.card:hover {
    transform: scale(1.02);
    box-shadow: 0px 10px 28px rgba(0, 0, 0, 0.18);
}

/* Title */
.card-body h3 {
    font-weight: 700;
    color: #2c3e50;
}

/* --- Form Styling --- */
.form-label {
    font-weight: 600;
    color: #34495e;
}

.form-control {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #d0d4d8;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(30, 64, 175, 0.3);
}
.btn-success {
    background: linear-gradient(135deg, #3b82f6, #1e40af); /* Changed to blue gradient */
    border: none;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    color: #ffffff;
    transition: transform .2s ease, box-shadow .2s ease;
}
.btn-success:hover {
    transform: scale(1.03);
    box-shadow: 0px 8px 20px rgba(30, 64, 175, 0.3); /* Adjusted shadow to match blue */
}

/* Back link styling */
a {
    color: #2980b9;
    font-weight: 600;
}
a:hover {
    color: #1d6fa5;
}

.btn-create-event {
    background-color: #3b82f6;
    border: none;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    color: #ffffff;
    transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
}

.btn-create-event:hover {
    background-color: #1d74f2;
    transform: scale(1.03);
    box-shadow: 0px 8px 22px rgba(59, 130, 246, 0.35);
}
</style>
@endpush
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Create New Event</h3>

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

                    <form method="POST" action="{{ route('organizer.createEvent') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Event Name</label>
        <input type="text" name="evt_name" 
               class="form-control @error('evt_name') is-invalid @enderror" 
               value="{{ old('evt_name') }}" required>
        @error('evt_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Event Details</label>
        <textarea name="evt_details" 
                  class="form-control @error('evt_details') is-invalid @enderror" 
                  rows="4" required>{{ old('evt_details') }}</textarea>
        @error('evt_details')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Event Date</label>
        <input type="date" name="evt_date" 
               class="form-control @error('evt_date') is-invalid @enderror" 
               value="{{ old('evt_date') }}" required>
        @error('evt_date')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <hr>
    <h5 class="form-label mb-3">Location</h5>

    <div class="mb-3">
        <label class="form-label">Location Name</label>
        <input type="text" name="evt_loctn_name" 
               class="form-control @error('evt_loctn_name') is-invalid @enderror" 
               value="{{ old('evt_loctn_name') }}" required>
        @error('evt_loctn_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Embed Map Link (Google Maps URL)</label>
        <input type="text" name="map_details" 
               class="form-control @error('map_details') is-invalid @enderror" 
               value="{{ old('map_details') }}" 
               placeholder="https://www.google.com/maps/embed... OR full <iframe> HTML">
        @error('map_details')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn-create-event w-100">Create Event</button>

    <div class="text-center mt-3">
                            <a href="{{ route('dashboard.organizer') }}">Back to Dashboard</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
