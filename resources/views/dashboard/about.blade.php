@extends('layouts.logged')

@section('title', 'About Us')

@push('styles')
  <style>
    .about-card { position: relative; background: url("{{ asset('images/about.jpg') }}") center/cover no-repeat; border-radius: 15px; color: #fff; overflow: hidden; }
    .about-card::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); /* dark overlay */ }
    .about-content { position: relative; padding: 60px; text-align: center; z-index: 1; }
    .card-img-top { height: 200px; object-fit: cover; }
  </style>
@endpush


@section('content')
<div class="container my-5">
  <div class="about-card mt-5">
    <div class="about-content text-center mt-5">
      <h1>About Us</h1>
      <p>
        The <b>Beach and Ocean Clean-up Hub</b> is a community-driven initiative 
        dedicated to protecting coastal and marine ecosystems by encouraging volunteerism, 
        environmental awareness, and sustainable practices. 
        We believe that through collective effort, small actions can make a big difference 
        in reducing marine debris and safeguarding our ocean for future generations.
      </p>
    </div>
  </div>
</div>

  <div class="container my-5">
  <div class="row g-4">
    <!-- Mission -->
    <div class="col-md-6">
      <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden">
        <img src="{{ asset('images/mission.jpg') }}" class="card-img-top" alt="Mission Image">
        <div class="card-body" 
             style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%); color: #ffffff;">
          <h2 class="fw-bold text-center mb-3">Our Mission</h2>
          <p class="text-center">
            To raise awareness and take action in protecting our oceans and beaches. 
            We aim to engage students, families, and communities in clean-up drives 
            and sustainable practices that reduce pollution and preserve marine ecosystems.
          </p>
        </div>
      </div>
    </div>

    <!-- Vision -->
    <div class="col-md-6">
      <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden">
        <img src="{{ asset('images/vision.jpeg') }}" class="card-img-top" alt="Vision Image">
        <div class="card-body" 
             style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #ffffff;">
          <h2 class="fw-bold text-center mb-3">Our Vision</h2>
          <p class="text-center">
            A cleaner, safer, and healthier environment where oceans thrive, 
            marine life is protected, and future generations can enjoy the beauty of nature 
            without the threat of pollution and destruction.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    
    function filterEvents() {
      const searchInput = document.getElementById('searchInput');
      const filter = searchInput.value.toUpperCase();
      const eventCards = document.getElementsByClassName('event-card');
      
      for (let i = 0; i < eventCards.length; i++) {
        const card = eventCards[i];
        const title = card.querySelector('.card-title').textContent;
        const description = card.querySelector('.card-text').textContent;
        const content = title + ' ' + description;
        
        if (content.toUpperCase().indexOf(filter) > -1) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      }
    }
  </script>
@endpush