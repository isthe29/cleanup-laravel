@extends('layouts.logged')

@section('title', 'Organizer Dashboard')

@section('dashboard', 'active')

@push('styles')
<style>

/* Card general styling */
.card {
    border-radius: 12px; 
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

/* Stat card titles and numbers */
.stat-card h5 {
    font-weight: 600; 
    font-size: 1.1rem;
    color: #fff;
}
.stat-card h3 {
    font-weight: 700; 
    font-size: 2rem;
    color: #fff;
}

/* Chart containers */
.chart-container {
    padding: 20px;
}

/* Dashboard header */
.dashboard-header {
    padding: 20px 15px; 
    background: linear-gradient(135deg, #2c2c2c 0%, #1e1e1e 100%); /* subtle dark gradient */
    color: #3b82f6;
    text-align: left;
    border-radius: 12px;
}

/* Greeting text */
.dashboard-greeting {
    font-weight: 700;
    font-size: 2rem;
     
}

/* White text utility */
.text-white-card {
    color: white !important;
}

/* Container */
.container-dashboard {
    max-width: 1200px; 
    margin: auto;
}

.event-list .card {
    background: linear-gradient(135deg, #2c2c2c 0%, #1e1e1e 100%); 
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    padding: 20px;
}


/* Event card inner details */
.event-card {
    background: #f8f9fa; /* light gray for inner event block */
    color: #212529;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 4px solid #3b82f6; /* subtle indicator */
}

/* Event titles */
.event-list h5 {
    color: #3b82f6;
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 15px;
}

/* Status badges */
.event-card .badge {
    font-size: 0.8rem;
    font-weight: 500;
}
/* Buttons inside stat cards (e.g., Create Event) */
.stat-card a, .stat-card a:hover {
    text-decoration: none;
    color: inherit;
}

.stat-card-gradient-1 { background: linear-gradient(135deg,#3b82f6 0%,#6c757d 100%); }
.stat-card-gradient-2 { background: linear-gradient(135deg,#3c68b1 0%,#6c757d 100%); }
.stat-card-gradient-3 { background: linear-gradient(135deg,#375a7f 0%,#6c757d 100%); }
.stat-card-gradient-create { background: linear-gradient(135deg,#0b5ed7 0%,#adb5bd 100%); cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease; }
.stat-card-gradient-create:hover {transform: scale(1.05); box-shadow: 0 8px 20px rgba(0,0,0,0.2);}
</style>
@endpush


@section('content')
<div class="container-dashboard p-4">
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
    <div class="dashboard-header mb-4">
        <div style="margin-left: 1rem;">
            <h1 class="dashboard-greeting">Welcome, Organizer!</h1>
            {{-- <div class="fw-bolder">{{ $organizer->org_name }} <br>
                <p class="fs-6">Organization Name</p>
            </div> --}}
        </div>
    </div>

    <!-- Top Stats -->
<div class="row g-4 mb-4 justify-content-center text-center">
    <div class="col-md-3">
        <a href="{{ route('organizer.createEventForm') }}" style="text-decoration-line: none">
            <div class="card p-3 stat-card stat-card-gradient-create text-center">
                <h5 class="text-white-card mb-3"style="font-size: 1.5rem;">Create Event</h5>
                <h3 class="text-white-card">
                    <i class="bi bi-plus-circle" style="font-size: 2.3rem;"></i>
                </h3>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-1">
            <h5 class="text-white-card">Total Events</h5>
            <h3 class="text-white-card">{{ $organizer->totl_evts_orgzd }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-2">
            <h5 class="text-white-card">Total Trash (kg)</h5>
            <h3 class="text-white-card">{{ $organizer->totl_trsh_collected_kg }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-3">
            <h5 class="text-white-card">Total Participants</h5>
            <h3 class="text-white-card">{{ $organizer->totl_partpts_overall }}</h3>
        </div>
    </div>
</div>


    <!-- Charts -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Monthly Trash Collected (kg)</h5>
                <canvas id="trashChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Events Per Month</h5>
                <canvas id="eventsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Volunteer Participation</h5>
                <canvas id="participantsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming and Ongoing Events -->
<div class="event-list row mt-4">

    <!-- UPCOMING EVENTS -->
    <div class="col-md-6">
        <div class="card mb-3 p-3" style="background: #1e1e1e; color:#fff; border-radius:12px;">
            <h5>Upcoming Events</h5>

            @forelse($upcomingEvents as $event)
                <div class="event-card mb-3 p-3" style="background:#fff; color:#000; border-radius:10px;">
                    <strong>{{ $event->evt_name }}</strong><br>
                    Date: {{ date('M d, Y', strtotime($event->evt_date)) }}<br>
                    Status: <span class="badge bg-info">{{ ucfirst($event->status) }}</span>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-circle" style="font-size: 2.5rem; color:#ffffff;"></i>
                    <p class="mt-2 text-light">No upcoming events.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ONGOING EVENTS -->
    <div class="col-md-6">
        <div class="card mb-3 p-3" style="background: #1e1e1e; color:#fff; border-radius:12px;">
            <h5 >Ongoing Events</h5>

            @forelse($ongoingEvents as $event)
                <div class="event-card mb-3 p-3" style="background:#fff; color:#000; border-radius:10px;">
                    <strong>{{ $event->evt_name }}</strong><br>
                    Date: {{ date('M d, Y', strtotime($event->evt_date)) }}<br>
                    Status: <span class="badge bg-success">{{ ucfirst($event->status) }}</span>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-circle" style="font-size: 2.5rem; color:#ffffff;"></i>
                    <p class="mt-2 text-light">No ongoing events.</p>
                </div>
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

new Chart(document.getElementById('trashChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Trash (kg)',
            data: @json($trashPerMonth),
            borderWidth: 2,
            borderColor: 'rgba(0,123,255,1)',
            backgroundColor:'rgba(0,123,255,0.25)',
            tension: 0.3,
            fill: true
        }]
    }
});

new Chart(document.getElementById('eventsChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Events',
            data: @json($eventsPerMonth),
            borderWidth: 1,
            backgroundColor:'rgba(0,123,255,0.7)',
            borderColor:'rgba(0,123,255,1)',
        }]
    }
});

new Chart(document.getElementById('participantsChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Participants'],
        datasets: [{
            data: [{{ $organizer->totl_partpts_overall }}, 100],
            backgroundColor: ['#0d6efd', '#6c757d']
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
