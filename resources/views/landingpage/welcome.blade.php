@extends('layouts.app')

@section('title', 'Welcome - Sustainable Fashion Archive')

@section('extra-css')
<style>
    :root {
        --archive-black: #000000;
        --nav-height: 70px;
    }

    /* Menggunakan font standar sistem/Inter agar tidak berubah */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* --- Hero Carousel --- */
    .hero-carousel {
        position: relative;
        height: 85vh;
        width: 100%;
        overflow: hidden;
        background-color: var(--archive-black);
        margin-top: calc(var(--nav-height) * -1);
    }

    .carousel-inner, .carousel-item {
        height: 100%;
    }

    .carousel-item img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        filter: brightness(0.5);
    }

    /* --- Hero Content --- */
    .hero-overlay-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        width: 100%;
        color: white;
        text-align: center;
    }

    .hero-title {
        font-size: clamp(2rem, 7vw, 4rem);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 0.75rem;
        letter-spacing: 5px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: block;
    }

    .btn-archive-white {
        border: 1px solid white;
        background: white;
        color: black;
        padding: 15px 35px;
        border-radius: 0;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-decoration: none;
        transition: 0.3s ease;
        display: inline-block;
    }

    .btn-archive-white:hover {
        background: transparent;
        color: white;
    }

    /* --- Sections --- */
    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: var(--archive-black);
    }

    .btn-dark-custom {
        background: var(--archive-black);
        color: white;
        padding: 15px 40px;
        border-radius: 0;
        border: none;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: 0.3s;
    }
</style>
@endsection

@section('content')
{{-- HERO SLIDESHOW --}}
<header class="hero-carousel">
    <div id="archiveHero" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="1000">
                <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070" alt="Slide 1">
            </div>
            <div class="carousel-item" data-bs-interval="1000">
                <img src="https://media.istockphoto.com/id/1151423624/id/foto/tampilan-gadis-yang-dipotong-dalam-pakaian-karang-hidup-berpose-di-bangku-di-atas-biru.jpg?s=2048x2048&w=is&k=20&c=kVJN23gnfbBhf7hhiuD5wr4rFvOzKml3XjLz4ZHXVtM=" alt="Slide 2">
            </div>
            <div class="carousel-item" data-bs-interval="1000">
                <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=1887" alt="Slide 3">
            </div>
        </div>
    </div>

    <div class="hero-overlay-content">
        <div class="container px-4">
            <span class="hero-subtitle" data-aos="fade-down">Sustainable Fashion</span>
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">The Archive</h1>
            <p class="lead mb-5 d-none d-md-block" data-aos="fade-up" data-aos-delay="400" style="font-weight: 400; max-width: 700px; margin: 0 auto 3rem; letter-spacing: 1px;">
                Prolonging fashion works through digital archiving and rental.
            </p>
            <div data-aos="zoom-in" data-aos-delay="600">
                <a href="{{ url('/catalog') }}" class="btn-archive-white">Explore Catalogue</a>
            </div>
        </div>
    </div>
</header>

{{-- ABOUT SECTION --}}
<section class="container py-5 mt-5">
    <div class="row justify-content-center text-center py-5">
        <div class="col-lg-8">
            <h2 class="fw-bold text-uppercase mb-4" data-aos="fade-up" style="letter-spacing: 2px;">About Our Program</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="200" style="line-height: 1.8;">
                Our sustainable fashion program is dedicated to preserving and prolonging the life of fashion works through digital archiving and a rental system.
            </p>
        </div>
    </div>

    <div class="row g-4 text-center py-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-icon"><i class="bi bi-archive"></i></div>
            <h6 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Digital Archive</h6>
            <p class="small text-muted">Comprehensive digital documentation of fashion works.</p>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-icon"><i class="bi bi-calendar-event"></i></div>
            <h6 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Rental Service</h6>
            <p class="small text-muted">Rent curated fashion pieces for special occasions.</p>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="feature-icon"><i class="bi bi-recycle"></i></div>
            <h6 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Sustainability</h6>
            <p class="small text-muted">Reduce fashion waste through shared access.</p>
        </div>
    </div>
</section>

{{-- CALL TO ACTION --}}
<section class="bg-light py-5 mt-5">
    <div class="container text-center py-5">
        <h2 class="fw-bold text-uppercase mb-3" data-aos="fade-down" style="letter-spacing: 2px;">Ready to Explore?</h2>
        <p class="text-muted mb-4" data-aos="fade-up">Browse our curated collection of fashion works available for rent</p>
        <div data-aos="zoom-in">
            <a href="{{ url('/catalog') }}" class="btn-dark-custom text-decoration-none">View Catalogue</a>
        </div>
    </div>
</section>
@endsection