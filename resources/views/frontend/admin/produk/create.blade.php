@extends('layouts.admin')

@section('title', 'Create New Product - Sustainable Fashion Archive')

@section('admin-content')
<div class="container-fluid px-0 pb-5">
    {{-- Breadcrumb & Header --}}
    <div class="mb-4 animate__animated animate__fadeIn">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}" class="text-decoration-none text-muted small">Products</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Add New Product</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.produk.index') }}" class="btn btn-white border rounded-circle p-2 shadow-sm hover-up">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-bold mb-0" style="letter-spacing: -1px;">Create New Item</h2>
        </div>
    </div>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="row g-4">
            {{-- Kolom Kiri --}}
            <div class="col-lg-8">
                {{-- Info Umum --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">General Information</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Product Name</label>
                        <input type="text" name="name" class="form-control border-0 bg-light p-3 rounded-3 @error('name') is-invalid @enderror" 
                               placeholder="e.g. Vintage Evening Gown" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Author / Designer</label>
                        <input type="text" name="author" class="form-control border-0 bg-light p-3 rounded-3" 
                               placeholder="e.g. Claire Dubois" value="{{ old('author') }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control border-0 bg-light p-3 rounded-3" 
                                  rows="4" placeholder="Describe the gown's elegance...">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- Media Gallery (3 Box Terpisah) --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-1">Product Images</h5>
                    <p class="text-muted small mb-4">Upload exactly 3 images: Main view, alternative angle, and material detail.</p>
                    
                    <div class="row g-3">
                        @for ($i = 0; $i < 3; $i++)
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">
                                {{ $i == 0 ? 'Main Photo' : 'Gallery Photo ' . $i }}
                            </label>
                            <div class="upload-box border-dashed rounded-4 position-relative d-flex flex-column align-items-center justify-content-center bg-light" style="height: 220px; transition: 0.3s; overflow: hidden;">
                                
                                {{-- Placeholder --}}
                                <div class="text-center p-3" id="placeholder-{{ $i }}">
                                    <i class="bi bi-plus-circle fs-3 text-muted"></i>
                                    <p class="mb-0 small fw-bold text-muted mt-2">Add Image</p>
                                </div>

                                {{-- Image Preview --}}
                                <img id="preview-{{ $i }}" class="img-fluid d-none w-100 h-100" style="object-fit: cover;">
                                
                                {{-- Hidden Input --}}
                                <input type="file" name="images[]" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" 
                                       style="cursor: pointer;" onchange="previewImage(this, {{ $i }})" accept="image/*" {{ $i == 0 ? 'required' : '' }}>
                                
                                {{-- Remove Button --}}
                                <button type="button" class="btn btn-dark btn-sm position-absolute top-0 end-0 m-2 d-none shadow-sm" 
                                        id="remove-{{ $i }}" onclick="resetImage({{ $i }})" style="border-radius: 8px;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- Spesifikasi Produk --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Product Specifications</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Year Made</label>
                            <input type="number" name="year_made" class="form-control border-0 bg-light p-3 rounded-3" placeholder="2018" value="{{ old('year_made') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Color</label>
                            <input type="text" name="color" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Black" value="{{ old('color') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Occasion</label>
                            <input type="text" name="occasion" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Evening / Gala" value="{{ old('occasion') }}">
                        </div>
                    </div>
                </div>

                {{-- Measurement Details --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Measurement Details (Inches)</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Bust</label>
                            <input type="text" name="measure_bust" class="form-control border-0 bg-light p-3 rounded-3" placeholder='36"'>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Waist</label>
                            <input type="text" name="measure_waist" class="form-control border-0 bg-light p-3 rounded-3" placeholder='28"'>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Hip</label>
                            <input type="text" name="measure_hip" class="form-control border-0 bg-light p-3 rounded-3" placeholder='38"'>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Length</label>
                            <input type="text" name="measure_length" class="form-control border-0 bg-light p-3 rounded-3" placeholder='58"'>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Pricing & Materials</h5>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Price per Week</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light text-muted fw-bold">Rp</span>
                            <input type="number" name="price" class="form-control border-0 bg-light p-3" placeholder="150000" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Materials</label>
                        <input type="text" name="materials" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Silk, Lace">
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Organization</h5>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Inventory Stock</label>
                        <input type="number" name="stock" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Quantity" value="1" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                        <div class="form-check form-switch p-3 bg-light rounded-3 border-0 d-flex align-items-center justify-content-between">
                            <label class="form-check-label fw-bold small" for="is_published">Publish to Catalog</label>
                            <input type="hidden" name="is_published" value="0">
                            <input class="form-check-input ms-0" type="checkbox" name="is_published" id="is_published" value="1" checked>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark p-3 rounded-pill fw-bold shadow hover-up">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Save Product
                    </button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-white border p-3 rounded-pill fw-bold">Discard Changes</a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .upload-box { border: 2px dashed #dee2e6; cursor: pointer; }
    .upload-box:hover { border-color: #000; background-color: #f1f1f1 !important; }
    .hover-up { transition: 0.3s; }
    .hover-up:hover { transform: translateY(-3px); }
</style>

<script>
    function previewImage(input, index) {
        const preview = document.getElementById(`preview-${index}`);
        const placeholder = document.getElementById(`placeholder-${index}`);
        const removeBtn = document.getElementById(`remove-${index}`);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                removeBtn.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage(index) {
        // Karena input images[] adalah array, kita ambil berdasarkan index
        const inputs = document.getElementsByName('images[]');
        const preview = document.getElementById(`preview-${index}`);
        const placeholder = document.getElementById(`placeholder-${index}`);
        const removeBtn = document.getElementById(`remove-${index}`);

        inputs[index].value = ''; // Reset file input
        preview.src = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        removeBtn.classList.add('d-none');
    }
</script>
@endsection