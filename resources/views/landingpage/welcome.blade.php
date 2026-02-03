@extends('layouts.app')
@section('title', 'Welcome - Sustainable Fashion Archive')
@section('extra-css')
<style>
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1558444458-5cf75194a0d4?q=80&w=2070');
        background-size: cover; background-position: center; height: 70vh;
        display: flex; align-items: center; justify-content: center; text-align: center; color: white;
    }
    .btn-outline-light-custom {
        border: 1px solid white; background: white; color: black;
        padding: 10px 25px; border-radius: 0; transition: 0.3s; text-decoration: none;
    }
    .btn-dark-custom {
        background: black; color: white; padding: 12px 30px; border-radius: 0; border: none;
    }
    .feature-icon { font-size: 2rem; margin-bottom: 15px; color: #555; }
</style>
@endsection
@section('content')
<header class="hero-section">
    <div class="container px-4">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Sustainable Fashion Archive</h1>
        <p class="lead mb-5" data-aos="fade-up" data-aos-delay="200">Prolonging fashion works through digital archiving and rental</p>
        <div data-aos="zoom-in" data-aos-delay="400">
            <a href="{{ url('/catalog') }}" class="btn-outline-light-custom fw-semibold">Explore Catalogue</a>
        </div>
    </div>
</header>

<section class="container py-5 mt-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4" data-aos="fade-up">About Our Program</h2>
            <p class="text-muted mb-5" data-aos="fade-up" data-aos-delay="200">
                Our sustainable fashion program is dedicated to preserving and prolonging the life of fashion works through digital archiving and a rental system.
            </p>
        </div>
    </div>

    <div class="row g-4 text-center py-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-icon"><i class="bi bi-archive"></i></div>
            <h5 class="fw-bold">Digital Archive</h5>
            <p class="small text-muted px-4">Comprehensive digital documentation of fashion works.</p>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-icon"><i class="bi bi-calendar-event"></i></div>
            <h5 class="fw-bold">Rental Service</h5>
            <p class="small text-muted px-4">Rent curated fashion pieces for special occasions.</p>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="feature-icon"><i class="bi bi-recycle"></i></div>
            <h5 class="fw-bold">Sustainability</h5>
            <p class="small text-muted px-4">Reduce fashion waste through shared access.</p>
        </div>
    </div>
</section>

<section class="bg-light py-5 mt-5">
    <div class="container text-center py-5">
        <h2 class="fw-bold mb-3" data-aos="fade-down">Ready to Explore?</h2>
        <p class="text-muted mb-4" data-aos="fade-up">Browse our curated collection of fashion works available for rent</p>
        <div data-aos="zoom-in">
            <a href="{{ url('/catalog') }}" class="btn btn-dark-custom">View Catalogue</a>
        </div>
    </div>
</section>
@endsection