@extends('layouts.logged')

@section('title', 'Volunteer Dashboard')
@section('dashboard', 'active')

@push('styles')
<style>
/* Card general styling */
.card { border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.25); }
.stat-card h5 { font-weight: 600; font-size: 1.1rem; color: #fff; }
.stat-card h3 { font-weight: 700; font-size: 2rem; color: #fff; }
.chart-container { padding: 20px; }
.dashboard-header { padding: 20px 15px; background: linear-gradient(135deg,#2c2c2c 0%,#1e1e1e 100%); color: #3b82f6; border-radius: 12px; }
.dashboard-greeting { font-weight: 700; font-size: 2rem; }
.text-white-card { color: white !important; }
.container-dashboard { max-width: 1200px; margin: auto; }
.event-list .card { background: linear-gradient(135deg,#2c2c2c 0%,#1e1e1e 100%); box-shadow: 0 6px 18px rgba(0,0,0,0.25); padding: 20px; }
.event-card { background: #f8f9fa; color: #212529; padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #3b82f6; }
.event-list h5 { color: #3b82f6; font-weight: 700; font-size: 1.25rem; margin-bottom: 15px; }
.event-card .badge { font-size: 0.8rem; font-weight: 500; }
.stat-card a, .stat-card a:hover { text-decoration: none; color: inherit; }
.stat-card-gradient-1 { background: linear-gradient(135deg,#3b82f6 0%,#6c757d 100%); }
.stat-card-gradient-2 { background: linear-gradient(135deg,#3c68b1 0%,#6c757d 100%); }
.stat-card-gradient-3 { background: linear-gradient(135deg,#375a7f 0%,#6c757d 100%); }
.btn-join { background-color: #0d6efd; color: #fff; border-radius: 6px; font-weight: 500; padding: 4px 10px; font-size: 0.85rem; }
.btn-join:hover { background-color: #084298; color: #fff; }
</style>
@endpush

@section('content')
<div class="container-dashboard p-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="dashboard-header mb-4">
        <h1 class="dashboard-greeting">Welcome, {{ $volunteer->usr_name }}!</h1>
    </div>

    <!-- Top Stats -->
    <div class="row g-4 mb-4 text-center">
        <div class="col-md-3">
            <div class="card p-3 stat-card stat-card-gradient-1">
                <h5 class="text-white-card">Total Events Participated</h5>
                <h3 class="text-white-card">{{ $volunteer->totl_evts_partd }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 stat-card stat-card-gradient-2">
                <h5 class="text-white-card">Currently Joined Events</h5>
                <h3 class="text-white-card">{{ $volunteer->evt_curr_joined }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 stat-card stat-card-gradient-3">
                <h5 class="text-white-card">Total Trash Collected (kg)</h5>
                <h3 class="text-white-card">{{ $volunteer->totl_trash_collected_kg }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="text-center mb-3">Monthly Events Participated</h5>
                <canvas id="eventsParticipatedChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="text-center mb-3">Monthly Trash Collected (kg)</h5>
                <canvas id="trashCollectedChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming & Joined Events -->
    <div class="row g-4 event-list">

        <!-- Upcoming Events -->
        <div class="col-md-6">
            <div class="card mb-3 p-3">
                <h5>Upcoming Events</h5>
                @forelse($upcomingEvents as $event)
                    <div class="event-card">
                        <strong>{{ $event->evt_name }}</strong><br>
                        Date: {{ date('M d, Y', strtotime($event->evt_date)) }}<br>
                        <form action="{{ route('volunteer.joinEvent', $event->evt_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-join mt-2">Join Event</button>
                        </form>
                    </div>
                @empty
                    <p class="text-light">No upcoming events to join.</p>
                @endforelse
            </div>
        </div>

        <!-- Joined Events -->
        <div class="col-md-6">
            <div class="card mb-3 p-3">
                <h5>Joined Events</h5>
                @forelse($joinedEvents as $event)
                    <div class="event-card">
                        <strong>{{ $event->evt_name }}</strong><br>
                        Date: {{ date('M d, Y', strtotime($event->evt_date)) }}<br>
                        Status: <span class="badge bg-success">Joined</span>
                    </div>
                @empty
                    <p class="text-light">No events joined yet.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

// Events Participated Chart
new Chart(document.getElementById('eventsParticipatedChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Events Participated',
            data: @json($eventsParticipatedPerMonth),
            backgroundColor: 'rgba(59,130,246,0.7)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 1
        }]
    }
});

// Trash Collected Chart
new Chart(document.getElementById('trashCollectedChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Trash Collected (kg)',
            data: @json($trashCollectedPerMonth),
            borderColor: 'rgba(0,123,255,1)',
            backgroundColor: 'rgba(0,123,255,0.25)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    }
});
</script>
@endpush
