@extends('layouts.user')

@section('title', 'Ruang Materi - Sustainable Fashion')

@section('extra-css')
<style>
    :root {
        --accent-color: #000;
        --soft-gray: #f8f9fa;
    }
    
    .page-header {
        padding: 60px 0 40px;
        background: radial-gradient(circle at top right, #fdfdfd, #f4f4f4);
        border-radius: 0 0 40px 40px;
    }

    .materi-card {
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: #fff;
    }

    .materi-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        border-color: var(--accent-color);
    }

    .img-container {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        margin: 12px;
    }

    .img-container img {
        transition: transform 0.6s ease;
    }

    .materi-card:hover .img-container img {
        transform: scale(1.1);
    }

    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.8);
        color: #000;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-learn {
        background: var(--accent-color);
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 16px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-learn:hover {
        background: #333;
        color: #fff;
        letter-spacing: 1px;
    }

    .materi-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1.3;
    }

    .stats-item {
        font-size: 0.8rem;
        color: #888;
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>
@endsection

@section('content')
<div class="page-header mb-5" data-aos="fade-down">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-soft-dark text-dark mb-2 px-3 py-2 rounded-pill border">E-Learning Platform</span>
                <h1 class="display-5 fw-extrabold text-dark mb-3">Ruang Belajar</h1>
                <p class="text-muted lead">Tingkatkan keahlianmu dalam teknik eco-printing dan kembangkan gaya fashion yang berkelanjutan.</p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        @foreach($materis as $materi)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
            <div class="card materi-card h-100 shadow-sm border-0">
                <div class="img-container">
                    <img src="{{ asset('storage/' . $materi->thumbnail) }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                    <div class="category-badge text-uppercase">{{ $materi->kategori }}</div>
                </div>
                
                <div class="card-body p-4 pt-2">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stats-item">
                            <i class="bi bi-book"></i> {{ $materi->subMateris->count() }} Modul
                        </div>
                        <div class="stats-item">
                            <i class="bi bi-person-video3"></i> Beginner
                        </div>
                    </div>

                    <h5 class="materi-title mb-3">{{ $materi->judul }}</h5>
                    @php
                        $persentase = auth()->user()->progressMateri($materi->id); // Buat method ini di Model User
                    @endphp

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted" style="font-size: 0.75rem; font-weight: 600;">Progres Belajar</span>
                            <span class="text-dark" style="font-size: 0.75rem; font-weight: 700;">{{ $persentase }}%</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: #eee; border-radius: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                style="width: {{ $persentase }}%; background-color: #000; border-radius: 10px;" 
                                aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {!! $materi->deskripsi !!}
                    </p>
                    
                    <div class="d-grid">
                        <a href="{{ route('customer.materi.show', $materi->id) }}" class="btn btn-learn d-flex align-items-center justify-content-center gap-2">
                            <span>Mulai Belajar</span>
                            <i class="bi bi-arrow-right-short fs-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection