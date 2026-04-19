@extends('layouts.admin')

@section('title', 'Tambah Konten Bab Multimedia')

@section('admin-content')
<div class="container-fluid">
    {{-- Assets Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        .nav-pills .nav-link { color: var(--text-muted); background: transparent; font-size: 0.85rem; transition: 0.3s; border: 1px solid #eee; margin-right: 5px; }
        .nav-pills .nav-link.active { background-color: #000 !important; color: #fff !important; }
        .upload-box { border: 2px dashed #ddd; border-radius: 15px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden; }
        .upload-box:hover { border-color: #000; background: #f9f9f9; }
        .quiz-card { border: 1px solid #eee; border-radius: 20px; background: #fff; }
        .option-box { background: #fbfbfb; border-radius: 12px; padding: 15px; border: 1px solid #f0f0f0; }
        .img-preview-mini { width: 100%; max-height: 100px; object-fit: cover; border-radius: 8px; margin-top: 8px; display: none; }
    </style>

    <div class="mb-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.submateri.index', $materi->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Batal
        </a>
        <span class="badge bg-soft-dark text-dark border px-3 py-2 rounded-pill">Materi Induk: Fundamental Eco-Printing</span>
    </div>

    <form action="{{ route('admin.submateri.store', $materi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            {{-- Kolom Kiri: Konten Utama --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <h5 class="fw-bold mb-4 text-dark">Detail Konten Bab</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Judul Sub-Materi</label>
                        <input type="text" name="judul" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Masukkan judul bab..." required>
                    </div>

                    {{-- Pilihan Tipe Konten --}}
                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Tipe Materi</label>
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item"><button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-text" type="button"><i class="bi bi-body-text me-2"></i>Teks</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-video" type="button"><i class="bi bi-play-circle me-2"></i>Video</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-pdf" type="button"><i class="bi bi-file-pdf me-2"></i>PDF</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#pills-quiz" type="button"><i class="bi bi-card-checklist me-2"></i>Kuis</button></li>
                    </ul>

                    <div class="tab-content">
                        {{-- Tab Teks --}}
                        <div class="tab-pane fade show active" id="pills-text">
                            <input id="trix_konten" type="hidden" name="konten">
                            <trix-editor input="trix_konten" class="bg-white" style="min-height: 350px; border-radius: 12px;"></trix-editor>
                        </div>

                        {{-- Tab Video --}}
                        <div class="tab-pane fade" id="pills-video">
                            <div class="p-4 bg-light rounded-4 text-center border">
                                <i class="bi bi-youtube text-danger fs-1"></i>
                                <h6 class="mt-2">YouTube URL</h6>
                                <input type="url" name="video_url" class="form-control border-0 shadow-sm rounded-3 p-3 mt-3" placeholder="https://youtube.com/embed/...">
                            </div>
                        </div>

                        {{-- Tab PDF --}}
                        <div class="tab-pane fade" id="pills-pdf">
                            <div class="upload-box p-5 text-center">
                                <input type="file" name="file_pdf" class="position-absolute w-100 h-100 opacity-0 top-0 start-0" accept=".pdf">
                                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                                <h6>Klik untuk unggah PDF</h6>
                                <p class="small text-muted">Maksimal ukuran file 10MB</p>
                            </div>
                        </div>

                        {{-- Tab Kuis --}}
                        <div class="tab-pane fade" id="pills-quiz">
                            <div id="quiz-wrapper">
                                <div class="quiz-card p-4 mb-4 shadow-sm border rounded-4 bg-white">
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2 align-items-center">
                                        <h6 class="fw-bold mb-0 text-dark">Pertanyaan #1</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                                    </div>
                                    
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-8">
                                            <label class="small fw-bold">Teks Pertanyaan</label>
                                            <textarea name="q_text[]" class="form-control bg-light border-0" rows="3" placeholder="Tulis pertanyaan di sini..." ></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small fw-bold">Gambar Soal (Opsional)</label>
                                            <input type="file" name="q_img[]" class="form-control form-control-sm border-0 bg-light" onchange="previewImg(this)">
                                            <img class="img-preview-mini mt-2 border d-none" style="max-height: 100px;">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        @foreach(['A', 'B', 'C', 'D'] as $opt)
                                        <div class="col-md-6">
                                            <div class="option-box p-3 border rounded-3 bg-light">
                                                <label class="fw-bold small text-primary mb-2">Pilihan {{ $opt }}</label>
                                                <input type="text" name="q_opt_{{ strtolower($opt) }}[]" class="form-control form-control-sm mb-2 border-0 shadow-sm" placeholder="Teks jawaban {{ $opt }}...">
                                                <input type="file" name="q_opt_img_{{ strtolower($opt) }}[]" class="form-control form-control-sm bg-white border-0" onchange="previewImg(this)">
                                                <img class="img-preview-mini border mt-2 d-none" style="max-height: 80px;">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-4 p-3 bg-soft-success rounded-3 border border-success border-opacity-25">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <label class="fw-bold text-success small"><i class="bi bi-check-circle-fill me-1"></i> Tentukan Kunci Jawaban</label>
                                                <select name="q_correct_ans[]" class="form-select form-select-sm border-success border-opacity-50">
                                                    <option value="" selected disabled>-- Pilih Jawaban Benar --</option>
                                                    <option value="a">Pilihan A</option>
                                                    <option value="b">Pilihan B</option>
                                                    <option value="c">Pilihan C</option>
                                                    <option value="d">Pilihan D</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted italic mt-2 d-block">* Pastikan teks pilihan yang dipilih sudah terisi.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-dark btn-sm rounded-pill px-4 mt-3" onclick="addQuestion()">
                                <i class="bi bi-plus-lg me-2"></i>Tambah Pertanyaan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Pengaturan --}}
            <div class="col-lg-4">
                {{-- Thumbnail Bab --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <h6 class="fw-bold mb-3">Thumbnail Sub-Materi</h6>
                    <div class="upload-box p-4 text-center" id="thumb-container">
                        <input type="file" name="thumbnail" class="position-absolute w-100 h-100 opacity-0 top-0 start-0" style="cursor: pointer" onchange="previewThumb(this)">
                        <div id="thumb-placeholder">
                            <i class="bi bi-image text-muted fs-2"></i>
                            <p class="small text-muted mb-0">Klik untuk upload cover bab</p>
                        </div>
                        <img id="thumb-preview" class="img-fluid rounded-3 d-none">
                    </div>
                </div>

                {{-- Urutan & Submit --}}
                <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius: 20px; top: 20px;">
                    <div class="mb-3">
                        <label class="small fw-bold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control border-0 bg-light p-3" placeholder="Otomatis">
                        <small class="text-muted d-block mt-1">Kosongkan untuk urutan terakhir.</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="small fw-bold">Estimasi Waktu</label>
                        <div class="input-group">
                            <input type="number" name="durasi" class="form-control border-0 bg-light p-3" placeholder="5">
                            <span class="input-group-text border-0 bg-light text-muted small">Menit</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow">
                        Simpan Konten Bab
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview gambar kecil (untuk kuis)
    function previewImg(input) {
        const preview = input.nextElementSibling;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview thumbnail utama
    function previewThumb(input) {
        const preview = document.getElementById('thumb-preview');
        const placeholder = document.getElementById('thumb-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambah pertanyaan kuis dinamis
    let questionCount = 1;

    function addQuestion() {
        questionCount++;
        const wrapper = document.getElementById('quiz-wrapper');
        const html = `
            <div class="quiz-card p-4 mb-4 shadow-sm border rounded-4 bg-white">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <h6 class="fw-bold mb-0">Pertanyaan #${questionCount}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="this.parentElement.parentElement.remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="small fw-bold">Teks Pertanyaan</label>
                        <textarea name="q_text[]" class="form-control bg-light border-0" rows="3" ></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="small fw-bold">Gambar Soal</label>
                        <input type="file" name="q_img[]" class="form-control form-control-sm border-0 bg-light" onchange="previewImg(this)">
                        <img class="img-preview-mini mt-2 border d-none" style="max-height: 100px;">
                    </div>
                </div>

                <div class="row g-3">
                    ${['a', 'b', 'c', 'd'].map(opt => `
                        <div class="col-md-6">
                            <div class="option-box p-2 border rounded bg-light">
                                <label class="fw-bold small text-primary mb-2 text-uppercase">Pilihan ${opt}</label>
                                <input type="text" name="q_opt_${opt}[]" class="form-control form-control-sm mb-2 shadow-sm" placeholder="Teks jawaban...">
                                <input type="file" name="q_opt_img_${opt}[]" class="form-control form-control-sm bg-white" onchange="previewImg(this)">
                                <img class="img-preview-mini border mt-2 d-none" style="max-height: 80px;">
                            </div>
                        </div>
                    `).join('')}
                </div>

                <div class="mt-4 p-3 bg-light rounded-3 border">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="fw-bold text-success small">
                                <i class="bi bi-check-circle-fill me-1"></i> Tentukan Kunci Jawaban
                            </label>
                            <select name="q_correct_ans[]" class="form-select form-select-sm" >
                                <option value="" selected disabled>-- Pilih Jawaban Benar --</option>
                                <option value="a">Pilihan A</option>
                                <option value="b">Pilihan B</option>
                                <option value="c">Pilihan C</option>
                                <option value="d">Pilihan D</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection