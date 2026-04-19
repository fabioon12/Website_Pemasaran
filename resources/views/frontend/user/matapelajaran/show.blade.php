@extends('layouts.user')

@section('title', 'Kurikulum: ' . $materi->judul)

@section('extra-css')
<style>
    .show-header {
        background: #000;
        color: #fff;
        padding: 60px 0;
        border-radius: 0 0 30px 30px;
    }
    .chapter-card {
        border: 1px solid #f0f0f0;
        border-radius: 15px;
        transition: 0.3s ease;
        text-decoration: none !important;
        display: block;
        background: #fff;
    }
    .chapter-card:hover {
        border-color: #000;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .icon-box {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        font-size: 1.2rem;
    }
    .chapter-card:hover .icon-box {
        background: #000;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="show-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.materi.index') }}" class="text-white-50">Materi</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <h1 class="display-6 fw-bold mb-3">{{ $materi->judul }}</h1>
                <p class="text-white-50 lead mb-0">{{ Str::limit(strip_tags($materi->deskripsi), 150) }}</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <img src="{{ asset('storage/' . $materi->thumbnail) }}" class="rounded-4 shadow shadow-lg" style="width: 100%; max-width: 300px; height: 200px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Daftar Bab Pembelajaran</h4>
            
            <div class="chapter-list">
                @forelse($materi->subMateris as $index => $sub)
                    <a href="{{ route('customer.materi.belajar', [$materi->id, $sub->id]) }}" class="chapter-card p-4 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box fw-bold">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">{{ $sub->judul }}</h6>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="bi bi-clock me-1"></i> {{ $sub->durasi ?? 5 }} Menit</span>
                                        <span>•</span>
                                        <span>
                                            @if($sub->video_url)
                                                <i class="bi bi-play-circle me-1"></i> Video Pembelajaran
                                            @elseif($sub->file_pdf)
                                                <i class="bi bi-file-earmark-pdf me-1"></i> Dokumen PDF
                                            @else
                                                <i class="bi bi-file-text me-1"></i> Artikel Teks
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada bab yang tersedia untuk materi ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h6 class="fw-bold mb-3">Informasi Materi</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Bab</span>
                    <span class="fw-bold">{{ $materi->subMateris->count() }} Modul</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Level</span>
                    <span class="badge bg-dark rounded-pill">All Levels</span>
                </div>
                <hr>
                <p class="small text-muted mb-4">Selesaikan semua bab untuk mendapatkan pemahaman mendalam tentang {{ $materi->judul }}.</p>
                
                @if($materi->subMateris->count() > 0)
                    <a href="{{ route('customer.materi.belajar', [$materi->id, $materi->subMateris->first()->id]) }}" class="btn btn-dark w-100 py-3 rounded-pill fw-bold">
                        MULAI BELAJAR SEKARANG
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection