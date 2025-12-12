@extends('layouts.logged')

@section ('title', 'Organizer Dashboard')

@section ('dashboard', 'active')

@push('styles')
<style>
    
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
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('organizer.createEvent') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Event Name</label>
                            <input type="text" name="evt_name" class="form-control" value="{{ old('evt_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Details</label>
                            <textarea name="evt_details" class="form-control" rows="4" required>{{ old('evt_details') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" name="evt_date" class="form-control" value="{{ old('evt_date') }}" required>
                        </div>

                        <hr>

                        <h5 class="mb-3">Location</h5>

                        <div class="mb-3">
                            <label class="form-label">Location Name</label>
                            <input type="text" name="evt_loctn_name" class="form-control" value="{{ old('evt_loctn_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Map Link (Google Maps URL)</label>
                            <input type="url" name="map_details" class="form-control" value="{{ old('map_details') }}" placeholder="https://www.google.com/maps/..." />
                        </div>

                        <button type="submit" class="btn btn-success w-100">Create Event</button>

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
