@extends('layouts.admin')

@section('title', 'Edit Materi: ' . $materi->judul)

@section('admin-content')
<div class="container-fluid">
    {{-- Import Trix Editor Asset --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        trix-editor {
            min-height: 450px !important;
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 15px;
            padding: 20px !important;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        trix-toolbar .trix-button-group {
            border: 1px solid var(--border-color) !important;
            background: var(--bg-body);
            border-radius: 10px;
        }

        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.01);
        }

        .upload-area:hover {
            border-color: var(--accent-color);
            background: rgba(0,0,0,0.03);
        }

        .preview-img {
            max-width: 100%;
            max-height: 180px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('admin.ruang-materi.index') }}" 
       class="btn btn-light border rounded-pill shadow-sm mb-4 px-3 d-inline-flex align-items-center gap-2" 
       style="height: 40px;">
        <i class="bi bi-arrow-left text-dark"></i>
        <span class="fw-semibold text-dark small">Kembali</span>
    </a>

    <form action="{{ route('admin.ruang-materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Penting: Laravel butuh ini untuk update --}}
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Edit Materi</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small text-muted">
                        <li class="breadcrumb-item"><a href="{{ route('admin.ruang-materi.index') }}" class="text-decoration-none text-muted">Ruang Materi</a></li>
                        <li class="breadcrumb-item active" aria-current="page text-dark">Update Data</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-clockwise fs-5"></i>
                    <span>Perbarui Materi</span>
                </button>
            </div>
        </div>

        <div class="row g-4">
            {{-- Kolom Utama --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4" style="background: var(--bg-card); border-radius: 20px;">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase tracking-wider">Judul Materi</label>
                        <input type="text" name="judul" class="form-control form-control-lg border-0 bg-light rounded-3 px-3 @error('judul') is-invalid @enderror" 
                               placeholder="Masukkan judul materi..." value="{{ old('judul', $materi->judul) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase tracking-wider">Kategori Materi</label>
                        <input type="text" name="kategori" class="form-control border-0 bg-light rounded-3 px-3 py-2 @error('kategori') is-invalid @enderror" 
                               placeholder="Contoh: Tekstil, Workshop, Bisnis..." value="{{ old('kategori', $materi->kategori) }}" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase tracking-wider mb-3">Isi Deskripsi / Materi</label>
                        <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $materi->deskripsi) }}">
                        <trix-editor input="deskripsi" placeholder="Tulis konten secara detail di sini..."></trix-editor>
                    </div>
                </div>
            </div>

            {{-- Kolom Samping --}}
            <div class="col-lg-4">
                {{-- Thumbnail Card --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="background: var(--bg-card); border-radius: 20px;">
                    <label class="form-label fw-bold small text-uppercase tracking-wider mb-3">Thumbnail</label>
                    
                    <div class="upload-area" onclick="document.getElementById('thumbnailInput').click()">
                        {{-- Jika materi sudah punya thumbnail, tampilkan langsung --}}
                        <div id="placeholderView" class="{{ $materi->thumbnail ? 'd-none' : '' }} text-center p-3">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            <p class="small text-muted mt-2">Pilih foto baru jika ingin mengganti</p>
                            <span class="btn btn-sm btn-outline-dark rounded-pill px-3">Unggah</span>
                        </div>
                        
                        <div id="previewContainer" class="{{ $materi->thumbnail ? '' : 'd-none' }} text-center p-2">
                            <img id="imagePreview" 
                                 src="{{ $materi->thumbnail ? asset('storage/' . $materi->thumbnail) : '#' }}" 
                                 class="preview-img mb-3" alt="Preview">
                            <p class="small text-primary fw-bold mb-0">Klik untuk mengganti foto</p>
                        </div>
                    </div>

                    <input type="file" name="thumbnail" id="thumbnailInput" class="d-none" accept="image/*" onchange="handleImagePreview(this)">
                </div>

                {{-- Status Card --}}
                <div class="card border-0 shadow-sm p-4" style="background: var(--bg-card); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Status Publikasi</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="published" 
                                   {{ old('status', $materi->status) == 'published' ? 'checked' : '' }} 
                                   role="switch" style="width: 45px; height: 22px;">
                        </div>
                    </div>
                    <p class="text-muted small mb-0">Geser untuk mempublikasikan atau menyimpan sebagai Draft.</p>
                </div>
                
                {{-- Info Metadata --}}
                <div class="card border-0 shadow-sm p-3 mt-4 bg-light bg-opacity-50" style="border-radius: 15px;">
                    <div class="small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Dibuat:</span>
                            <span class="text-dark fw-medium">{{ $materi->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Terakhir Update:</span>
                            <span class="text-dark fw-medium">{{ $materi->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function handleImagePreview(input) {
        const placeholder = document.getElementById('placeholderView');
        const container = document.getElementById('previewContainer');
        const img = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                placeholder.classList.add('d-none');
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("trix-file-accept", function(event) {
        event.preventDefault();
        alert("Lampiran file tidak diizinkan di dalam editor.");
    });
</script>
@endsection