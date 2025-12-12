@extends('layouts.logged')

@section('title', 'Events')
@section('events', 'active')

@push('styles')
<style>
body { background: #252525; scroll-behavior: smooth; }
.hero-section { padding: 80px 20px; text-align:center; color: #fff; }
.hero-content h1 { font-size: 2.5rem; background: linear-gradient(135deg, #006994 0%, #00bcd4 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.body-container { background: rgba(0,123,255,0.1); border-radius: 10px; margin: 20px auto; padding: 20px; color: #fff; }
.event-card { background: #fff; color: #000; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.3s; }
.event-card:hover { transform: translateY(-5px); }
.event-map { width: 100%; height: 200px; border:0; display:block; }
.event-info { padding: 15px; }
.btn-join { background: linear-gradient(135deg,#0077b6 0%,#00b4d8 100%); color:#fff; border:none; width:100%; padding:10px; border-radius:8px; font-weight:bold; }
.btn-join:hover { background: linear-gradient(135deg,#005f8a 0%,#0098b8 100%); }
.modal-content { border-radius: 12px; }
</style>
@endpush

@section('content')

<!-- Hero -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Together, We Make Waves of Change!</h1>
        <p>Join our clean-up events—protect our shores and our future.</p>
    </div>
</section>

<!-- Search + Events -->
<div class="body-container container">
    <div class="d-flex justify-content-between mb-4 flex-wrap gap-2">
        <h2 class="fw-bold text-light mb-0 align-self-center">Events</h2>
        <input type="text" id="searchInput" class="form-control" placeholder="Search events..." style="max-width:250px" onkeyup="filterEvents()">
    </div>

    <div class="row g-4" id="eventsContainer">
        @forelse($events as $event)
        <div class="col-lg-4 col-md-6 col-sm-12 event-card-wrapper">
            <div class="event-card">
                @if($event->location && $event->location->map_details)
                    <iframe class="event-map" src="{{ $event->location->map_details }}" allowfullscreen="" loading="lazy"></iframe>
                @endif
                <div class="event-info">
                    <h5 class="event-name">{{ $event->evt_name }}</h5>
                    <p class="text-muted"><i class="bi bi-person-fill text-primary"></i> {{ $event->organizer->org_name ?? 'Organizer info here' }}</p>
                    <p><i class="bi bi-geo-alt-fill text-primary"></i> {{ $event->location->evt_loctn_name ?? 'Location not set' }}</p>
                    <p><i class="bi bi-calendar-event text-primary"></i> {{ \Carbon\Carbon::parse($event->evt_date)->format('F j, Y') }}</p>
                    <a href="#" class="btn btn-join" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->evt_id }}">Join Event</a>
                </div>
            </div>
        </div>

        <!-- Event Modal -->
        <div class="modal fade" id="eventModal{{ $event->evt_id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $event->evt_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Organizer:</strong> {{ $event->organizer->org_name ?? 'Organizer info here' }}</p>
                        <p>{{ $event->evt_details }}</p>
                        <p><strong>Location Map:</strong></p>
                        @if($event->location && $event->location->map_details)
                            <iframe class="event-map" src="{{ $event->location->map_details }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        @endif
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->evt_date)->format('F j, Y') }} @if($event->end_date) - {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }} @endif</p>
                        <p><strong>Status:</strong> {{ $event->status }}</p>
                        <p><strong>Trash Collected:</strong> {{ $event->trsh_collected_kg ?? 0 }} kg</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-primary">Join Event</a>
                    </div>
                </div>
            </div>
        </div>

        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-exclamation-circle" style="font-size: 3rem; color:#ffffff;"></i>
            <p class="mt-3 text-light fs-5">No events found.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterEvents() {
    const input = document.getElementById('searchInput').value.toUpperCase();
    const cards = document.querySelectorAll('.event-card-wrapper');

    cards.forEach(card => {
        const title = card.querySelector('.event-name').textContent.toUpperCase();
        card.style.display = title.indexOf(input) > -1 ? '' : 'none';
    });
}
</script>
@endpush
