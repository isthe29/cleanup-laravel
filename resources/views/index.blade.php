@extends('layouts.main')

@section('title', 'Home')

@push('styles')
@endpush

@section('content')
<section id="hub" class="hub-section">
    <div class=" position-relative overflow-hidden container-margin-bottom rounded-3">
      <div class="d-flex min-vh-50" lc-helper="video-bg">
        <video style="z-index:1;object-fit: cover; object-position: 50% 50%;" class="position-absolute w-100 min-vh-100" autoplay="" preload="" muted="" loop="" playsinline="">
          <!-- adjust object-position to tweak cropping on mobile -->
          <source src="{{ asset('videos/hero.mp4')}}" type="video/mp4">
        </video>
        <div style="z-index:2; margin-top: 150px; margin-bottom: 150px;" class="align-self-center text-center text-light col-md-8 offset-md-2">
          <div class="lc-block mb-4">
            <div editable="rich">
              <h1 class="display-1 fw-bolder override-color-white" style="font-size: 100px">Protect Our Beaches,<br>Save Our Oceans.</h1>
            </div>
          </div>

          <div class="lc-block">
            <div editable="rich">
              <p class="" style="font-size: 30px; margin: 0 auto;">Join a movement dedicated to cleaning up coastlines and preserving marine life.</p>
              <p class="" style="font-size: 30px; margin: 0 auto;">Every action counts.</p>  
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="container my-5">
        <div class="container my-5">
          <div class="container my-5">
            <div class="card shadow-lg border-0 p-5 rounded-4" style="background: linear-gradient(135deg, #006994 0%, #00bcd4 100%); color: #ffffff; opacity: 0.95;">
              <div class="text-center mb-4">
                <h1 class="fw-bold override-color-white">Welcome to the Beach & Ocean Clean-up Hub</h1>
              </div>
              <p class="lead text-start">Our oceans give us life, beauty, and joy—but they need our help. Every year, thousands of kilos of waste end up on our beaches and in our waters. This hub was created to encourage students and community members to take part in local beach and ocean clean-up drives.</p>
              <p class="lead text-start">Together, we can raise awareness, protect marine life, and keep our shores clean for future generations. Join us and be part of the movement toward a healthier, cleaner environment.</p>
              <div class="text-center mt-4">
                <a href="login.html" class="btn btn-outline-light btn-lg fw-bold">Join us!</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="container my-5">
      <div class="row g-4">
        <!-- What We Do -->
        <div class="col-md-6">
          <div class="card h-100 shadow-lg border-0 rounded-4 p-4" 
              style="background: linear-gradient(135deg, #005f73 0%, #0a9396 100%);
                      color: #ffffff; opacity: 0.95;">
            <h2 class="fw-bold text-center mb-3">What We Do</h2>
            <ul class="list-unstyled lead">
              <li>Organize beach and coastal clean-up events.</li>
              <li>Educate the community on ocean conservation.</li>
              <li>Collaborate with local organizations and authorities.</li>
              <li>Advocate for eco-friendly policies and practices.</li>
            </ul>
          </div>
        </div>

        <!-- Why It Matters -->
        <div class="col-md-6">
          <div class="card h-100 shadow-lg border-0 rounded-4 p-4" 
              style="background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
                      color: #ffffff; opacity: 0.95;">
            <h2 class="fw-bold text-center mb-3">Why It Matters</h2>
            <ul class="list-unstyled lead">
              <li>Protects marine life from harmful pollution.</li>
              <li>Preserves the natural beauty of our beaches.</li>
              <li>Supports biodiversity and healthier ecosystems.</li>
              <li>Raises awareness about environmental impact.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container my-5">
      <div class="card shadow-lg border-0 rounded-4 p-5 text-center"style="background: linear-gradient(135deg, #219ebc 0%, #8ecae6 100%);color: #ffffff; opacity: 0.95;">
        <h2 class="fw-bold mb-4">How You Can Help</h2>
        <p class="lead mb-4">Everyone can make a difference! Whether big or small, your actions help keep our oceans and beaches clean for future generations.</p>

        <div class="row g-4">
          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: rgba(0,0,0,0.25);">
              <h5 class="fw-bold">Join Clean-Up Events</h5>
              <p>Volunteer your time to help remove litter and restore our coasts.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: rgba(0,0,0,0.25);">
              <h5 class="fw-bold">Spread Awareness</h5>
              <p>Educate friends, family, and community about protecting marine life.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-3 rounded-3 h-100" style="background: rgba(0,0,0,0.25);">
              <h5 class="fw-bold">Live Sustainably</h5>
              <p>Reduce plastic use, recycle, and adopt eco-friendly habits daily.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section> 
@endsection

@push('scripts')
<script>
    //page-specific JS
</script>
@endpush
