@extends('layouts.admin')

@section('title', 'Daftar Sub-Materi')

@section('admin-content')
<div class="container-fluid">
    <div class="mb-4">
        {{-- Tombol kembali menggunakan route index materi utama --}}
        <a href="{{ route('admin.ruang-materi.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 mb-3 shadow-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Materi Utama
        </a>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                {{-- Nama materi utama diambil secara dinamis --}}
                <h3 class="fw-bold mb-1" style="color: var(--text-main);">Kurikulum: {{ $materi->judul }}</h3>
                <p class="text-muted small mb-0">Kelola urutan bab dan konten edukasi untuk materi ini.</p>
            </div>
            <div class="d-flex gap-2">
                {{-- Link tambah disesuaikan dengan parameter ID materi --}}
                <a href="{{ route('admin.submateri.create', $materi->id) }}" class="btn btn-dark px-4 rounded-3 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Tambah Bab Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 15px;">
                <div class="text-muted small mb-1">Total Sub-Bab</div>
                <div class="h5 fw-bold mb-0">{{ $subMateris->count() }} Bab</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3" style="background: var(--bg-card); border-radius: 15px;">
                <div class="text-muted small mb-1">Estimasi Waktu</div>
                <div class="h5 fw-bold mb-0 text-primary">{{ $subMateris->sum('durasi') }} Menit</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="background: var(--bg-card); border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="border-0 ps-4 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);" width="100px">Urutan</th>
                            <th class="border-0 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">Judul Sub-Bab</th>
                            <th class="border-0 py-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">Durasi</th>
                            <th class="border-0 pe-4 py-3 text-end text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-muted);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid var(--border-color);">
                        @forelse($subMateris as $sub)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-dark text-white fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    {{ $sub->urutan }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold mb-0" style="color: var(--text-main);">{{ $sub->judul }}</div>
                                <span class="text-muted small">
                                    @if($sub->video_url) <i class="bi bi-youtube me-1"></i> Video @endif
                                    @if($sub->file_pdf) <i class="bi bi-file-earmark-pdf me-1"></i> PDF @endif
                                    @if($sub->konten) <i class="bi bi-text-paragraph me-1"></i> Teks @endif
                                    @if($sub->quizzes->whereNotNull('pertanyaan_teks')->count() > 0) 
                                        <i class="bi bi-patch-question me-1"></i> {{ $sub->quizzes->whereNotNull('pertanyaan_teks')->count() }} Soal 
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock me-1 text-primary"></i> {{ $sub->durasi ?? 0 }} Menit
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.submateri.edit', [$materi->id, $sub->id]) }}" class="btn btn-sm btn-light border rounded-3" style="width: 32px; height: 32px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Delete Button (Menggunakan Form) --}}
                                    <form action="{{ route('admin.submateri.destroy', [$materi->id, $sub->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border rounded-3 hover-danger" style="width: 32px; height: 32px;" onclick="return confirm('Apakah anda yakin ingin menghapus bab ini?')">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">
                                Belum ada sub-materi untuk kurikulum ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-light bg-opacity-25 border-0 p-3">
            <p class="text-center text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i> Urutan bab akan muncul secara otomatis jika tidak ditentukan secara manual.
            </p>
        </div>
    </div>
</div>

{{-- Style tetap sama --}}
<style>
    .table tbody tr { transition: all 0.2s ease; border-bottom: 1px solid rgba(0,0,0,0.03); }
    .table tbody tr:hover { background-color: rgba(0,0,0,0.01) !important; transform: scale(1.001); }
    [data-theme="dark"] .table tbody tr:hover { background-color: rgba(255,255,255,0.03) !important; }
    .hover-danger:hover { background-color: #dc3545 !important; border-color: #dc3545 !important; }
    .hover-danger:hover i { color: white !important; }
    .badge { font-weight: 500; letter-spacing: 0.02em; }
</style>
@endsection