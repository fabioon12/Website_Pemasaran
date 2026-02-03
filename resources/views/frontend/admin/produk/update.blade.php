@extends('layouts.admin')

@section('title', 'Edit Product - Sustainable Fashion Archive')

@section('admin-content')
<div class="container-fluid px-0 pb-5">
    {{-- Breadcrumb & Header --}}
    <div class="mb-4 animate__animated animate__fadeIn">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}" class="text-decoration-none text-muted small">Products</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Edit Product</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-white border rounded-circle p-2 shadow-sm">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold mb-0" style="letter-spacing: -1px;">Edit Item</h2>
                    <span class="text-muted small" >#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
            @if($product->is_published)
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border-0 fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i> ACTIVE IN CATALOG
                </span>
            @else
                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2 border-0 fw-bold">
                    <i class="bi bi-eye-slash-fill me-1"></i> DRAFT
                </span>
            @endif
        </div>
    </div>

    <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            {{-- Kolom Kiri --}}
            <div class="col-lg-8">
                {{-- Info Umum --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">General Information</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Product Name</label>
                        <input type="text" name="name" class="form-control border-0 bg-light p-3 rounded-3 @error('name') is-invalid @enderror" 
                               value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Author / Designer</label>
                        <input type="text" name="author" class="form-control border-0 bg-light p-3 rounded-3" 
                               value="{{ old('author', $product->author) }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control border-0 bg-light p-3 rounded-3" 
                                  rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                {{-- Spesifikasi Produk --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Product Specifications</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Year Made</label>
                            <input type="number" name="year_made" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('year_made', $product->year_made) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Color</label>
                            <input type="text" name="color" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('color', $product->color) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Occasion</label>
                            <input type="text" name="occasion" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('occasion', $product->occasion) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Size Label</label>
                            <select name="size_label" class="form-select border-0 bg-light p-3 rounded-3">
                                @foreach(['S', 'M', 'L', 'XL'] as $size)
                                    <option value="{{ $size }}" {{ old('size_label', $product->size_label) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Detail Pengukuran --}}
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Measurement Details (Inches)</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Bust</label>
                            <input type="text" name="measure_bust" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('measure_bust', $product->measure_bust) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Waist</label>
                            <input type="text" name="measure_waist" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('measure_waist', $product->measure_waist) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Hip</label>
                            <input type="text" name="measure_hip" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('measure_hip', $product->measure_hip) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Length</label>
                            <input type="text" name="measure_length" class="form-control border-0 bg-light p-3 rounded-3" 
                                   value="{{ old('measure_length', $product->measure_length) }}">
                        </div>
                    </div>
                </div>

                {{-- Media Gallery --}}
                <div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-3">Media Gallery</h5>
                    
                    {{-- Foto Saat Ini --}}
                    <div class="mb-4">
                        <label class="small text-muted d-block mb-3 text-uppercase fw-bold">Current Photos</label>
                        <div class="d-flex flex-wrap gap-3">
                            @if($product->images && count($product->images) > 0)
                                @foreach($product->images as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $img) }}" class="preview-img shadow-sm" alt="Product">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted small italic">No images uploaded.</p>
                            @endif
                        </div>
                    </div>

                    <div class="upload-zone border-dashed rounded-4 p-5 text-center position-relative" id="dropzone">
                        <i class="bi bi-images fs-1 text-muted"></i>
                        <h6 class="mt-3 fw-bold">Click to upload new images</h6>
                        <p class="small text-muted">This will replace current images</p>
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
                            <input type="number" name="price" class="form-control border-0 bg-light p-3" 
                                   value="{{ old('price', $product->price) }}" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Materials</label>
                        <input type="text" name="materials" class="form-control border-0 bg-light p-3 rounded-3" 
                               value="{{ old('materials', $product->materials) }}">
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 24px;">
                    <h5 class="fw-bold mb-4">Organization</h5>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Inventory Stock</label>
                        <input type="number" name="stock" class="form-control border-0 bg-light p-3 rounded-3" 
                               value="{{ old('stock', $product->stock) }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                        <div class="form-check form-switch p-3 bg-light rounded-3 border-0 d-flex align-items-center justify-content-between">
                            <label class="form-check-label fw-bold small" for="is_published">Publish to Catalog</label>
                            <input class="form-check-input ms-0" type="checkbox" name="is_published" id="is_published" value="1" 
                                   {{ old('is_published', $product->is_published) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark p-3 rounded-pill fw-bold shadow hover-up">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-white border p-3 rounded-pill fw-bold">Discard</a>
                    
                    <hr class="my-3 opacity-50">
                    <button type="button" class="btn btn-outline-danger p-3 rounded-pill fw-bold border-0" onclick="confirmDelete()">
                        <i class="bi bi-trash3 me-2"></i>Delete Product
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Form Delete (Hidden) --}}
    <form id="deleteForm" action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
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
    // Live Preview untuk gambar baru
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        [...this.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="preview-img animate__animated animate__zoomIn">
                        <span class="badge bg-dark position-absolute top-0 start-50 translate-middle-x mt-1 small" style="font-size:10px">NEW</span>
                    </div>
                `;
                previewContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });

    // Konfirmasi Hapus
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This item will be permanently removed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection