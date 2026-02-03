@extends('layouts.admin')

@section('title', 'Product Management - Sustainable Fashion Archive')

@section('admin-content')
<div class="container-fluid px-0">
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-5 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-bold mb-1" style="letter-spacing: -1px;">Inventory Archive</h2>
            <p class="text-muted small mb-0">Manage your product collection and rental availability.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.produk.index') }}" method="GET" class="input-group shadow-sm rounded-pill bg-white overflow-hidden border">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0 small" placeholder="Search products..." value="{{ request('search') }}" style="font-size: 0.85rem;">
            </form>
            
            <button onclick="exportToExcel()" class="btn btn-outline-success shadow-sm px-4 rounded-pill fw-semibold small d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i>
                <span class="d-none d-sm-inline">Export Excel</span>
            </button>

            <a href="{{ route('admin.produk.create') }}" class="btn btn-dark shadow px-4 rounded-pill fw-semibold small d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-sm-inline">Add Product</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-box-seam-fill fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total Products</p>
                        <h4 class="fw-bold mb-0">{{ $products->total() }} Items</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-megaphone-fill fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Live on Catalog</p>
                        {{-- Catatan: counts ini biasanya dikirim dari Controller untuk hasil yang akurat secara global --}}
                        <h4 class="fw-bold mb-0">{{ $products->where('is_published', true)->count() }} Items</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-eye-slash-fill fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Drafted (Hidden)</p>
                        <h4 class="fw-bold mb-0">{{ $products->where('is_published', false)->count() }} Items</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
        <div class="card-body p-0">
            <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0">Product List</h5>
                <p class="text-muted small mb-0">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} items</p>
            </div>
            
            <div class="table-responsive">
                <table id="productTable" class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light bg-opacity-50">
                            <th class="ps-4 py-3 text-muted small fw-bold border-0">ID</th>
                            <th class="py-3 text-muted small fw-bold border-0">PRODUCT</th>
                            <th class="py-3 text-muted small fw-bold border-0 text-center">DESCRIPTION</th>
                            <th class="py-3 text-muted small fw-bold border-0 text-center">PRICE</th>
                            <th class="py-3 text-muted small fw-bold border-0 text-center">STOCK</th>
                            <th class="pe-4 py-3 text-muted small fw-bold border-0 text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr style="border-bottom: 1px solid #f8f9fa !important;">
                            <td class="ps-4 py-4">
                                <span class="fw-bold text-muted" style="font-size: 0.85rem;">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="py-4">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $images = is_array($p->images) ? $p->images : json_decode($p->images, true);
                                        $imagePath = (!empty($images) && isset($images[0])) 
                                            ? asset('storage/' . $images[0]) 
                                            : 'https://ui-avatars.com/api/?name='.urlencode($p->name).'&background=000&color=fff';
                                    @endphp
                                    <div class="rounded-4 bg-light shadow-sm" style="width: 50px; height: 50px; background: url('{{ $imagePath }}') center/cover;"></div>
                                    <div>
                                        <div class="fw-bold mb-1" style="font-size: 0.9rem;">{{ $p->name }}</div>
                                        @if($p->is_published)
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.6rem;">PUBLISHED</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary fw-bold" style="font-size: 0.6rem;">DRAFT</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center py-4">
                                <span class="text-muted small">{{ Str::limit($p->description, 25) }}</span>
                            </td>
                            <td class="text-center py-4">
                                <div class="fw-bold small">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="text-center py-4">
                                @php
                                    $color = $p->stock <= 0 ? 'danger' : ($p->stock < 5 ? 'warning' : 'success');
                                @endphp
                                <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill" style="font-size: 0.7rem;">
                                    {{ $p->stock }} items
                                </span>
                            </td>
                            <td class="pe-4 py-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.produk.edit', $p->id) }}" class="btn btn-white border btn-sm rounded-pill shadow-sm hover-up">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Delete permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white border btn-sm rounded-circle shadow-sm hover-up text-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            <div class="d-flex justify-content-center py-4 border-top">
                <div class="admin-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-up { transition: all 0.2s ease; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; }

    /* Customizing Pagination Style */
    .admin-pagination .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .admin-pagination .page-item .page-link {
        border-radius: 8px !important;
        border: none;
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 16px;
    }
    .admin-pagination .page-item.active .page-link {
        background-color: #000;
        color: #fff;
    }
    .admin-pagination .page-link:focus {
        box-shadow: none;
    }
</style>

{{-- Script for Excel Export --}}
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
function exportToExcel() {
    var table = document.getElementById("productTable");
    var wb = XLSX.utils.table_to_book(table, { sheet: "Inventory List" });
    var filename = "Inventory_Archive_" + new Date().toLocaleDateString().replace(/\//g, '-') + ".xlsx";
    XLSX.writeFile(wb, filename);
}
</script>
@endsection