@extends('layouts.admin')

@section('title', 'Edit Konten Bab')

@section('admin-content')
<div class="container-fluid">
    {{-- Assets Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        .nav-pills .nav-link { color: var(--text-muted); background: transparent; font-size: 0.85rem; transition: 0.3s; border: 1px solid #eee; margin-right: 5px; }
        .nav-pills .nav-link.active { background-color: #000 !important; color: #fff !important; }
        .upload-box { border: 2px dashed #ddd; border-radius: 15px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden; min-height: 150px; display: flex; align-items: center; justify-content: center; flex-direction: column; }
        .upload-box:hover { border-color: #000; background: #f9f9f9; }
        .quiz-card { border: 1px solid #eee; border-radius: 20px; background: #fff; }
        .option-box { background: #fbfbfb; border-radius: 12px; padding: 15px; border: 1px solid #f0f0f0; }
        .img-preview-mini { width: 100%; max-height: 120px; object-fit: cover; border-radius: 8px; margin-top: 8px; display: block; }
        .img-preview-mini:empty { display: none; }
    </style>

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.submateri.index', $materi->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <span class="badge bg-soft-dark text-dark border px-3 py-2 rounded-pill">Materi: {{ $materi->judul }}</span>
    </div>

    <form action="{{ route('admin.submateri.update', [$materi->id, $subMateri->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            {{-- Kolom Kiri --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <h5 class="fw-bold mb-4 text-dark">Edit Detail Konten</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Judul Sub-Materi</label>
                        <input type="text" name="judul" class="form-control border-0 bg-light p-3 rounded-3" value="{{ old('judul', $subMateri->judul) }}" required>
                    </div>

                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item"><button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-text" type="button">Teks</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-video" type="button">Video</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-pdf" type="button">PDF</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-quiz" type="button">Kuis ({{ $subMateri->quizzes->count() }})</button></li>
                    </ul>

                    <div class="tab-content">
                        {{-- Tab Teks --}}
                        <div class="tab-pane fade show active" id="pills-text">
                            <input id="trix_konten" type="hidden" name="konten" value="{{ old('konten', $subMateri->konten) }}">
                            <trix-editor input="trix_konten" class="bg-white" style="min-height: 350px; border-radius: 12px;"></trix-editor>
                        </div>

                        {{-- Tab Video --}}
                        <div class="tab-pane fade" id="pills-video">
                            <div class="p-4 bg-light rounded-4 border">
                                <label class="small fw-bold mb-2">YouTube URL</label>
                                <input type="url" name="video_url" class="form-control border-0 shadow-sm p-3 rounded-3" value="{{ old('video_url', $subMateri->video_url) }}" placeholder="https://youtube.com/embed/...">
                            </div>
                        </div>

                        {{-- Tab PDF --}}
                        <div class="tab-pane fade" id="pills-pdf">
                            <div class="upload-box p-4 text-center">
                                <input type="file" name="file_pdf" class="position-absolute w-100 h-100 opacity-0 top-0 start-0" accept=".pdf">
                                <i class="bi bi-file-earmark-pdf fs-1 text-muted"></i>
                                @if($subMateri->file_pdf)
                                    <p class="text-success small fw-bold mb-0">File Terpasang: {{ basename($subMateri->file_pdf) }}</p>
                                    <span class="text-muted extra-small">Klik untuk mengganti file</span>
                                @else
                                    <h6>Unggah PDF Baru</h6>
                                @endif
                            </div>
                        </div>

                        {{-- Tab Kuis --}}
                        <div class="tab-pane fade" id="pills-quiz">
                            <div id="quiz-wrapper">
                                @foreach($subMateri->quizzes as $index => $quiz)
                                <div class="quiz-card p-4 mb-4 shadow-sm border">
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                        <h6 class="fw-bold mb-0">Pertanyaan #{{ $index + 1 }}</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button>
                                    </div>
                                    
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-8">
                                            <label class="small fw-bold">Teks Pertanyaan</label>
                                            <textarea name="q_text[]" class="form-control bg-light border-0" rows="3">{{ $quiz->pertanyaan_teks }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small fw-bold">Gambar Soal</label>
                                            <input type="file" name="q_img[]" class="form-control form-control-sm border-0 bg-light" onchange="previewImg(this)">
                                            @if($quiz->pertanyaan_gambar)
                                                <img src="{{ asset('storage/' . $quiz->pertanyaan_gambar) }}" class="img-preview-mini mt-2 border">
                                            @else
                                                <img class="img-preview-mini mt-2 border" style="display:none">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                                        <div class="col-md-6">
                                            <div class="option-box">
                                                <label class="fw-bold small text-primary mb-2 text-uppercase">Pilihan {{ $opt }}</label>
                                                <input type="text" name="q_opt_{{ $opt }}[]" class="form-control form-control-sm mb-2" value="{{ $quiz->{'jawaban_'.$opt.'_teks'} }}">
                                                <input type="file" name="q_opt_img_{{ $opt }}[]" class="form-control form-control-sm bg-white" onchange="previewImg(this)">
                                                @if($quiz->{'jawaban_'.$opt.'_gambar'})
                                                    <img src="{{ asset('storage/' . $quiz->{'jawaban_'.$opt.'_gambar'}) }}" class="img-preview-mini border">
                                                @else
                                                    <img class="img-preview-mini border" style="display:none">
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-dark btn-sm rounded-pill px-4" onclick="addQuestion()">
                                <i class="bi bi-plus-lg me-2"></i>Tambah Pertanyaan Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <h6 class="fw-bold mb-3">Thumbnail Sub-Materi</h6>
                    <div class="upload-box p-4 text-center">
                        <input type="file" name="thumbnail" class="position-absolute w-100 h-100 opacity-0 top-0 start-0" style="cursor: pointer" onchange="previewThumb(this)">
                        @if($subMateri->thumbnail)
                            <img id="thumb-preview" src="{{ asset('storage/' . $subMateri->thumbnail) }}" class="img-fluid rounded-3">
                            <p class="small text-muted mb-0 mt-2" id="thumb-placeholder">Klik untuk ganti gambar</p>
                        @else
                            <div id="thumb-placeholder">
                                <i class="bi bi-image text-muted fs-2"></i>
                                <p class="small text-muted mb-0">Klik untuk upload cover</p>
                            </div>
                            <img id="thumb-preview" class="img-fluid rounded-3 d-none">
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius: 20px; top: 20px;">
                    <div class="mb-3">
                        <label class="small fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control border-0 bg-light p-3" value="{{ old('urutan', $subMateri->urutan) }}">
                    </div>
                    
                    <div class="mb-4">
                        <label class="small fw-bold">Estimasi Waktu (Menit)</label>
                        <input type="number" name="durasi" class="form-control border-0 bg-light p-3" value="{{ old('durasi', $subMateri->durasi) }}">
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow">
                        Update Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Logic preview dan tambah pertanyaan sama dengan halaman Create
    function previewImg(input) {
        const preview = input.nextElementSibling;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewThumb(input) {
        const preview = document.getElementById('thumb-preview');
        const placeholder = document.getElementById('thumb-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { 
                preview.src = e.target.result; 
                preview.classList.remove('d-none');
                if(placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    let questionCount = {{ $subMateri->quizzes->count() }};
    function addQuestion() {
        questionCount++;
        const wrapper = document.getElementById('quiz-wrapper');
        const html = `
            <div class="quiz-card p-4 mb-4 shadow-sm border animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <h6 class="fw-bold mb-0">Pertanyaan #${questionCount}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-8"><label class="small fw-bold">Teks Pertanyaan</label><textarea name="q_text[]" class="form-control bg-light border-0" rows="3"></textarea></div>
                    <div class="col-md-4"><label class="small fw-bold">Gambar Soal</label><input type="file" name="q_img[]" class="form-control form-control-sm border-0 bg-light" onchange="previewImg(this)"><img class="img-preview-mini mt-2 border" style="display:none"></div>
                </div>
                <div class="row g-3">
                    ${['a', 'b', 'c', 'd'].map(opt => `
                        <div class="col-md-6">
                            <div class="option-box">
                                <label class="fw-bold small text-primary mb-2 text-uppercase">Pilihan ${opt}</label>
                                <input type="text" name="q_opt_${opt}[]" class="form-control form-control-sm mb-2">
                                <input type="file" name="q_opt_img_${opt}[]" class="form-control form-control-sm bg-white" onchange="previewImg(this)">
                                <img class="img-preview-mini border" style="display:none">
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection