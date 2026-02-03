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
            <a href="{{ route('admin.produk.index') }}" class="btn btn-white border rounded-circle p-2 shadow-sm">
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

                {{-- Spesifikasi Produk (Sesuai Attr Grid) --}}
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
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Occasion</label>
                            <input type="text" name="occasion" class="form-control border-0 bg-light p-3 rounded-3" placeholder="Evening / Gala" value="{{ old('occasion') }}">
                        </div>
                        <!-- <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Size Label</label>
                            <select name="size_label" class="form-select border-0 bg-light p-3 rounded-3">
                                <option value="S">S</option>
                                <option value="M" selected>M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div> -->
                    </div>
                </div>

                {{-- Detail Pengukuran (Section Box) --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Measurement Details (Inches)</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Bust</label>
                            <input type="text" name="measure_bust" class="form-control border-0 bg-light p-3 rounded-3" placeholder="36\"">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Waist</label>
                            <input type="text" name="measure_waist" class="form-control border-0 bg-light p-3 rounded-3" placeholder="28\"">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Hip</label>
                            <input type="text" name="measure_hip" class="form-control border-0 bg-light p-3 rounded-3" placeholder="38\"">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Length</label>
                            <input type="text" name="measure_length" class="form-control border-0 bg-light p-3 rounded-3" placeholder="58\"">
                        </div>
                    </div>
                </div>

                {{-- Media Gallery --}}
                <div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-3">Media Gallery</h5>
                    <div class="upload-zone border-dashed rounded-4 p-5 text-center position-relative" id="dropzone">
                        <i class="bi bi-images fs-1 text-muted"></i>
                        <h6 class="mt-3 fw-bold">Click to upload or drag and drop</h6>
                        <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;">
                    </div>
                    <div id="imagePreviewContainer" class="d-flex flex-wrap gap-3 mt-4"></div>
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
                            
                            <input class="form-check-input ms-0" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }}>
                        </div>
                        <small class="text-muted" style="font-size: 0.65rem;">If turned off, this item will be saved as a draft.</small>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark p-3 rounded-pill fw-bold shadow hover-up">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Save Product
                    </button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-white border p-3 rounded-pill fw-bold">Discard</a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .upload-zone { border: 2px dashed #dee2e6; background: #f8f9fa; transition: 0.3s; }
    .upload-zone:hover { border-color: #000 !important; background: #fff !important; }
    .preview-img { width: 80px; height: 100px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .hover-up { transition: 0.3s; }
    .hover-up:hover { transform: translateY(-3px); }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        [...this.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-img');
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection