@extends('layouts.admin')

@section('title', 'Manajemen Ruang Materi')

@section('admin-content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-main);">Ruang Materi</h3>
            <p class="text-muted small mb-0">Kelola kurikulum edukasi dan aset materi utama Anda.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.ruang-materi.create') }}" class="btn btn-dark px-4 rounded-3 shadow-sm d-flex align-items-center">
                <i class="bi bi-plus-lg me-2"></i> Tambah Materi
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 18px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-journal-text fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ number_format($stats['total_materi']) }}</h5>
                        <p class="text-muted small mb-0">Total Materi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 18px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-layers fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ number_format($stats['total_sub']) }}</h5>
                        <p class="text-muted small mb-0">Sub-Materi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 18px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-eye fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ number_format($stats['total_views']) }}</h5>
                        <p class="text-muted small mb-0">Total Views</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 18px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-tag fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ number_format($stats['total_kategori']) }}</h5>
                        <p class="text-muted small mb-0">Kategori</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="background: var(--bg-card); border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="border-0 ps-4 py-3" width="35%" style="color: var(--text-muted); font-size: 0.8rem; text-uppercase: tracking-wider;">Detail Materi</th>
                            <th class="border-0 py-3" style="color: var(--text-muted); font-size: 0.8rem; text-uppercase: tracking-wider;">Kategori</th>
                            <th class="border-0 py-3" style="color: var(--text-muted); font-size: 0.8rem; text-uppercase: tracking-wider;">Status</th>
                            <th class="border-0 pe-4 py-3 text-end" style="color: var(--text-muted); font-size: 0.8rem; text-uppercase: tracking-wider;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid var(--border-color);">
                        @forelse($materis as $materi)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($materi->thumbnail)
                                        <img src="{{ asset('storage/' . $materi->thumbnail) }}" 
                                             class="rounded-3 object-fit-cover shadow-sm border" 
                                             style="width: 100px; height: 60px;">
                                    @else
                                        <div class="rounded-3 bg-light d-flex align-items-center justify-content-center border shadow-sm" style="width: 100px; height: 60px;">
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>
                                    @endif
                                    <div class="ms-1">
                                        <h6 class="fw-bold mb-1" style="color: var(--text-main);">{{ $materi->judul }}</h6>
                                        <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.75rem;">
                                            <span><i class="bi bi-calendar3 me-1"></i> {{ $materi->created_at->format('d M Y') }}</span>
                                            <span>•</span>
                                            <span><i class="bi bi-eye me-1"></i> {{ number_format($materi->views) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2" style="font-size: 0.75rem;">{{ $materi->kategori }}</span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" {{ $materi->status == 'published' ? 'checked' : '' }} disabled>
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.submateri.index', $materi->id) }}" class="btn btn-sm btn-outline-dark rounded-3 px-3 d-flex align-items-center gap-2" style="font-size: 0.75rem; height: 32px;">
                                        <i class="bi bi-layers"></i>
                                        <span class="fw-semibold text-nowrap">Sub-Materi</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.ruang-materi.edit', $materi->id) }}" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;" title="Edit">
                                        <i class="bi bi-pencil-square text-dark"></i>
                                    </a>

                                    <form action="{{ route('admin.ruang-materi.destroy', $materi->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center justify-content-center shadow-sm hover-danger btn-delete" style="width: 32px; height: 32px;" title="Hapus">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-3">
                                    <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">Belum ada materi ditemukan.</p>
                                    <a href="{{ route('admin.ruang-materi.create') }}" class="btn btn-sm btn-dark rounded-pill px-4">Buat Materi Pertama</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($materis->hasPages())
        <div class="card-footer border-0 bg-transparent px-4 py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    Showing {{ $materis->firstItem() }} to {{ $materis->lastItem() }} of {{ $materis->total() }} entries
                </div>
                <div class="pagination-wrapper">
                    {{ $materis->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Pagination Styling */
    .pagination { margin-bottom: 0; gap: 5px; }
    .page-link {
        border-radius: 8px !important;
        color: var(--text-main);
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    .page-item.active .page-link {
        background-color: #000 !important;
        border-color: #000 !important;
        color: #fff !important;
    }
    .page-link:hover { background-color: var(--bg-body); color: var(--text-main); }
    
    .object-fit-cover { object-fit: cover; }
    
    /* Hover Effect */
    .table tbody tr { transition: all 0.2s ease; }
    .table tbody tr:hover { background-color: rgba(0,0,0,0.015) !important; }
    [data-theme="dark"] .table tbody tr:hover { background-color: rgba(255,255,255,0.03) !important; }

    .form-check-input:checked { background-color: #000; border-color: #000; }

    /* Action Buttons */
    .hover-danger:hover { background-color: #dc3545 !important; border-color: #dc3545 !important; }
    .hover-danger:hover i { color: white !important; }
    .btn-light.border:hover { background-color: #f8f9fa; border-color: #000 !important; }
</style>

{{-- SweetAlert2 untuk konfirmasi hapus --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Materi?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection