@extends('layouts.user')

@section('title', 'Belajar: ' . $subMateri->judul)

@section('extra-css')
<style>
    :root {
        --accent-color: #000;
        --success-color: #198754;
        --danger-color: #dc3545;
    }

    .learning-container { margin-top: 20px; }
    
    /* Navigasi Tipe Konten Modern */
    .nav-content-type {
        background: #f8f9fa;
        padding: 8px;
        border-radius: 16px;
        border: 1px solid #eee;
        display: inline-flex;
    }
    .nav-content-type .nav-link {
        color: #666;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: 0.3s;
        border: none;
    }
    .nav-content-type .nav-link.active {
        background: var(--accent-color) !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Media Containers */
    .video-container { 
        position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; 
        border-radius: 20px; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
    
    .content-area { line-height: 1.8; color: #333; font-size: 1.1rem; }
    .content-area img { max-width: 100%; border-radius: 15px; margin: 20px 0; }
    
    .pdf-viewer { width: 100%; height: 750px; border-radius: 20px; border: 1px solid #eee; }
    
    /* Sidebar Styling */
    .sidebar-learning { position: sticky; top: 100px; height: calc(100vh - 120px); overflow-y: auto; }
    .nav-item-sub { 
        padding: 16px; border-radius: 15px; transition: 0.3s; 
        border: 1px solid #f0f0f0; margin-bottom: 12px; display: block; text-decoration: none; color: #444;
        background: #fff;
    }
    .nav-item-sub:hover { border-color: var(--accent-color); background: #fdfdfd; }
    .nav-item-sub.active { background: var(--accent-color); color: #fff; border-color: var(--accent-color); }
    .nav-item-sub.active .text-muted { color: rgba(255,255,255,0.7) !important; }

    /* Quiz Styling */
    .option-item {
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #eee;
    }
    .option-item:hover {
        background-color: #f8f9fa;
        border-color: var(--accent-color);
    }
    .option-item.correct {
        background-color: #d1e7dd !important;
        border-color: var(--success-color) !important;
    }
    .option-item.wrong {
        background-color: #f8d7da !important;
        border-color: var(--danger-color) !important;
    }
    .option-item.disabled {
        pointer-events: none;
    }
    .btn-check-custom {
        width: 30px;
        height: 30px;
        min-width: 30px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .quiz-card.answered {
    opacity: 0.85;
    }
    .quiz-card.answered .option-item {
        cursor: default !important;
        pointer-events: none;
    }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
</style>
@endsection

@section('content')
<div class="container-fluid px-lg-5 learning-container mb-5">
    <div class="row g-4">
        {{-- Area Konten Kiri --}}
        <div class="col-lg-8">
            {{-- Navigasi Atas --}}
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('customer.materi.show', $subMateri->ruang_materi_id) }}" 
                   class="btn btn-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" 
                   style="width: 45px; height: 45px; border: 1px solid #eee;">
                    <i class="bi bi-arrow-left fs-5"></i>
                </a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('customer.materi.index') }}" class="text-muted text-decoration-none">Materi</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.materi.show', $subMateri->ruang_materi_id) }}" class="text-muted text-decoration-none">{{ Str::limit($subMateri->ruangMateri->judul, 25) }}</a></li>
                        <li class="breadcrumb-item active fw-bold text-dark">{{ Str::limit($subMateri->judul, 25) }}</li>
                    </ol>
                </nav>
            </div>

            <h2 class="fw-bold mb-4">{{ $subMateri->judul }}</h2>

            {{-- Tab Switcher --}}
            <div class="text-center mb-4">
                <ul class="nav nav-pills nav-content-type" id="contentTab" role="tablist">
                    @if($subMateri->konten)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="text-tab" data-bs-toggle="pill" data-bs-target="#content-text" type="button" role="tab">
                            <i class="bi bi-file-text me-2"></i>Teks
                        </button>
                    </li>
                    @endif
                    
                    @if($subMateri->video_url)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$subMateri->konten ? 'active' : '' }}" id="video-tab" data-bs-toggle="pill" data-bs-target="#content-video" type="button" role="tab">
                            <i class="bi bi-play-circle me-2"></i>Video
                        </button>
                    </li>
                    @endif

                    @if($subMateri->file_pdf)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ (!$subMateri->konten && !$subMateri->video_url) ? 'active' : '' }}" id="pdf-tab" data-bs-toggle="pill" data-bs-target="#content-pdf" type="button" role="tab">
                            <i class="bi bi-file-earmark-pdf me-2"></i>PDF
                        </button>
                    </li>
                    @endif
                    
                    @if($subMateri->quizzes->whereNotNull('pertanyaan_teks')->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="quiz-tab" data-bs-toggle="pill" data-bs-target="#content-quiz" type="button" role="tab">
                            <i class="bi bi-card-checklist me-2"></i>Kuis
                        </button>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Content Display --}}
            <div class="tab-content" id="contentTabContent">
                {{-- Teks --}}
                @if($subMateri->konten)
                <div class="tab-pane fade show active" id="content-text" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <div class="content-area">
                            {!! $subMateri->konten !!}
                        </div>
                    </div>
                </div>
                @endif

                {{-- Video --}}
                @if($subMateri->video_url)
                <div class="tab-pane fade {{ !$subMateri->konten ? 'show active' : '' }}" id="content-video" role="tabpanel">
                    <div class="video-container shadow-lg">
                        @php
                            $url = $subMateri->video_url;
                            $embedUrl = str_contains($url, 'watch?v=') ? str_replace('watch?v=', 'embed/', $url) : $url;
                        @endphp
                        <iframe src="{{ $embedUrl }}" allowfullscreen></iframe>
                    </div>
                </div>
                @endif

                {{-- PDF --}}
                @if($subMateri->file_pdf)
                <div class="tab-pane fade {{ (!$subMateri->konten && !$subMateri->video_url) ? 'show active' : '' }}" id="content-pdf" role="tabpanel">
                    <iframe src="{{ asset('storage/' . $subMateri->file_pdf) }}" class="pdf-viewer shadow-sm"></iframe>
                </div>
                @endif

                {{-- Kuis --}}
                @if($subMateri->quizzes->count() > 0)
                <div class="tab-pane fade" id="content-quiz" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h4 class="fw-bold mb-4 text-center">Uji Pemahaman</h4>
                        
                        @foreach($subMateri->quizzes as $index => $quiz)
                            <div class="quiz-card p-4 mb-4 border rounded-4" id="quiz-container-{{ $quiz->id }}">
                                <p class="fw-bold fs-5 mb-4">{{ $index + 1 }}. {{ $quiz->pertanyaan_teks }}</p>

                                {{-- Tampilkan gambar pertanyaan jika ada --}}
                                @if($quiz->pertanyaan_gambar)
                                    <img src="{{ asset('storage/' . $quiz->pertanyaan_gambar) }}" class="img-fluid rounded-3 mb-3" style="max-height: 300px;">
                                @endif
                                
                                <div class="options-list d-grid gap-3">
                                    @foreach(['a', 'b', 'c', 'd'] as $letter)
                                        {{-- Mengambil nama kolom sesuai di controller admin: jawaban_a_teks, dll --}}
                                        @php 
                                            $txtField = "jawaban_{$letter}_teks"; 
                                            $imgField = "jawaban_{$letter}_gambar";
                                        @endphp

                                        @if($quiz->$txtField || $quiz->$imgField)
                                            <div class="option-item d-flex align-items-center p-3 rounded-3" 
                                                onclick="checkAnswer('{{ $quiz->id }}', '{{ $letter }}', '{{ $quiz->kunci_jawaban }}')">
                                                
                                                <div class="btn-check-custom me-3 d-flex align-items-center justify-content-center border rounded-circle">
                                                    {{ strtoupper($letter) }}
                                                </div>

                                                <div>
                                                    @if($quiz->$txtField)
                                                        <span>{{ $quiz->$txtField }}</span>
                                                    @endif

                                                    @if($quiz->$imgField)
                                                        <img src="{{ asset('storage/' . $quiz->$imgField) }}" class="d-block mt-2 rounded" style="max-height: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Area Feedback --}}
                                <div class="feedback-area mt-4 d-none" id="feedback-{{ $quiz->id }}">
                                    <div class="p-3 rounded-3 d-flex align-items-center">
                                        <i class="bi me-2 fs-4"></i>
                                        <span class="message fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            {{-- Widget Skor --}}
            <div id="score-board" class="card border-0 bg-dark text-white rounded-4 p-3 mb-4 d-none shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small mb-0 opacity-75">Nilai Anda</p>
                        <h3 class="fw-bold mb-0 text-warning" id="final-score">0</h3>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-dark rounded-pill px-3" id="correct-count">0 Benar</span>
                        <span class="badge bg-danger rounded-pill px-3" id="wrong-count">0 Salah</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="sidebar-learning">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-4 text-uppercase small text-muted">Daftar Materi</h6>
                    <div class="nav-list">
                        @foreach($allSub as $sub)
                            @php $isSelesai = auth()->user()->subMaterisSelesai->contains($sub->id); @endphp
                            <a href="{{ route('customer.materi.belajar', [$sub->ruang_materi_id, $sub->id]) }}" 
                               class="nav-item-sub {{ $sub->id == $subMateri->id ? 'active' : '' }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-shrink-0">
                                        @if($isSelesai)
                                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                        @else
                                            <div class="rounded-circle border d-flex align-items-center justify-content-center text-muted small" style="width: 24px; height: 24px;">
                                                {{ $loop->iteration }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">{{ $sub->judul }}</div>
                                        <div class="text-muted extra-small" style="font-size: 0.7rem;">
                                            <i class="bi bi-clock me-1"></i>{{ $sub->durasi ?? '5' }} mnt
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
let totalQuestions = {{ $subMateri->quizzes->count() }};
let answeredCount = 0;
let correctAnswers = 0;

function checkAnswer(quizId, selected, correct) {
    const container = document.getElementById(`quiz-container-${quizId}`);
    
    // Cegah user klik soal yang sudah dijawab
    if (container.classList.contains('answered')) return;
    container.classList.add('answered');

    answeredCount++;
    const feedback = document.getElementById(`feedback-${quizId}`);
    feedback.classList.remove('d-none');
    
    const message = feedback.querySelector('.message');
    const box = feedback.querySelector('div');
    const icon = feedback.querySelector('i');

    // Cek Jawaban
    if (selected.toLowerCase() === correct.toLowerCase()) {
        correctAnswers++;
        // Tampilan Feedback Benar
        box.className = 'p-3 rounded-3 d-flex align-items-center bg-success bg-opacity-10 text-success';
        icon.className = 'bi bi-check-circle-fill me-2 fs-4';
        message.innerText = "Luar biasa! Jawaban Anda benar.";
    } else {
        // Tampilan Feedback Salah
        box.className = 'p-3 rounded-3 d-flex align-items-center bg-danger bg-opacity-10 text-danger';
        icon.className = 'bi bi-x-circle-fill me-2 fs-4';
        message.innerText = `Maaf, jawaban yang tepat adalah pilihan ${correct.toUpperCase()}.`;
    }

    // Jika semua soal sudah dijawab, tampilkan Skor Akhir
    if (answeredCount === totalQuestions) {
        showFinalResult();
    }
}

function showFinalResult() {
    const scoreBoard = document.getElementById('score-board');
    const finalScore = document.getElementById('final-score');
    const correctBadge = document.getElementById('correct-count');
    const wrongBadge = document.getElementById('wrong-count');

    // Hitung Skor (Skala 100)
    let score = Math.round((correctAnswers / totalQuestions) * 100);

    // Update UI
    finalScore.innerText = score;
    correctBadge.innerText = `${correctAnswers} Benar`;
    wrongBadge.innerText = `${totalQuestions - correctAnswers} Salah`;

    scoreBoard.classList.remove('d-none');
    
    // Scroll otomatis ke atas agar user lihat nilainya
    window.scrollTo({ top: scoreBoard.offsetTop - 100, behavior: 'smooth' });
}
</script>
@endsection