@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sustainable Fashion Archive')

@section('admin-content')
<div class="container-fluid px-0">
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4 mb-md-5 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-bold mb-1" style="letter-spacing: -1px; font-size: calc(1.3rem + 0.6vw);">Welcome back, Admin 👋</h2>
            <p class="text-muted small mb-0">Overview of your fashion archive performance today.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-white border shadow-sm px-3 px-md-4 rounded-pill fw-semibold small flex-grow-1 flex-md-grow-0">
                <i class="bi bi-download me-2"></i> <span class="d-none d-sm-inline">Export Report</span>
            </button>
            <a href="{{ route('admin.produk.create') }}" class="btn btn-dark shadow px-3 px-md-4 rounded-pill fw-semibold small flex-grow-1 flex-md-grow-0 d-flex align-items-center justify-content-center">
                <i class="bi bi-plus-lg me-2"></i> New Item
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 g-md-4 mb-4 mb-md-5">
        {{-- Total Revenue - Diambil dari Booking --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card border-0 shadow-sm p-3 p-md-4 h-100 position-relative overflow-hidden bg-white" style="border-radius: 20px;">
                <div class="stat-icon bg-success bg-opacity-10 text-success mb-2 mb-md-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-currency-exchange fs-5"></i>
                </div>
                <p class="text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Total Revenue</p>
                <h3 class="fw-bold mb-0">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Total Bookings --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card border-0 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-radius: 20px;">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary mb-2 mb-md-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-bag-check-fill fs-5"></i>
                </div>
                <p class="text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Total Rent</p>
                <h3 class="fw-bold mb-0">{{ $totalBookings ?? 0 }} <span class="text-muted fw-normal fs-6">Orders</span></h3>
            </div>
        </div>

        {{-- Pending Approval - Sync dengan Booking --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card border-0 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-radius: 20px;">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning mb-2 mb-md-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock-fill fs-5"></i>
                </div>
                <p class="text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Pending</p>
                <h3 class="fw-bold mb-0">{{ $pendingCount ?? 0 }} <span class="text-muted fw-normal fs-6">Wait</span></h3>
            </div>
        </div>

        {{-- Total Items - Sync dengan Produk --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card border-0 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-radius: 20px;">
                <div class="stat-icon bg-info bg-opacity-10 text-info mb-2 mb-md-3" style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-layers-fill fs-5"></i>
                </div>
                <p class="text-muted fw-bold text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Archive Items</p>
                <h3 class="fw-bold mb-0">{{ $productsCount ?? 0 }} <span class="text-muted fw-normal fs-6">Items</span></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Recent Bookings Table --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Recent Transactions</h5>
                            <p class="text-muted small mb-0">Latest rental activities.</p>
                        </div>
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold border text-uppercase" style="font-size: 0.65rem;">View All</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="text-muted border-bottom" style="font-size: 0.75rem;">
                                    <th class="pb-3 fw-semibold">PRODUCT</th>
                                    <th class="pb-3 fw-semibold d-none d-md-table-cell">CUSTOMER</th>
                                    <th class="pb-3 fw-semibold text-center">STATUS</th>
                                    <th class="pb-3 fw-semibold text-end">PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr class="border-bottom" style="border-color: #f8f9fa !important;">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @php
                                                $imgs = is_array($booking->product->images) ? $booking->product->images : json_decode($booking->product->images, true);
                                                $imgUrl = (is_array($imgs) && count($imgs) > 0) ? asset('storage/' . $imgs[0]) : 'https://ui-avatars.com/api/?name='.$booking->product->name;
                                            @endphp
                                            <div class="rounded-3" style="width: 40px; height: 40px; background: url('{{ $imgUrl }}') center/cover;"></div>
                                            <div class="fw-semibold small text-truncate" style="max-width: 150px;">{{ $booking->product->name }}</div>
                                        </div>
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell">
                                        <div class="small fw-medium">{{ $booking->user->name }}</div>
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $color = match(strtolower($booking->status)) {
                                                'approved' => 'success',
                                                'pending' => 'warning',
                                                'rejected' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-pill px-2 py-1 border-0 fw-bold" style="font-size: 0.6rem;">{{ strtoupper($booking->status) }}</span>
                                    </td>
                                    <td class="py-3 text-end fw-bold small">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">No recent bookings.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Alert Section --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1">Inventory Alert</h5>
                    <p class="text-muted small mb-4">Items that need restocking soon.</p>

                    <div class="d-flex flex-column gap-3">
                        @forelse($lowStockProducts as $lp)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-4 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white rounded-3 shadow-sm p-1">
                                    <i class="bi bi-exclamation-triangle text-danger"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small mb-0">{{ Str::limit($lp->name, 15) }}</div>
                                    <small class="text-muted">{{ $lp->stock }} items left</small>
                                </div>
                            </div>
                            <a href="{{ route('admin.produk.edit', $lp->id) }}" class="btn btn-white btn-sm border rounded-circle"><i class="bi bi-pencil-small"></i></a>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle-fill text-success fs-2 mb-2"></i>
                            <p class="small text-muted">All items are well stocked!</p>
                        </div>
                        @endforelse
                    </div>

                    @if($lowStockProducts->count() > 0)
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-dark w-100 rounded-pill mt-4 fw-bold small">Manage Inventory</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card { transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); }
    @media (max-width: 576px) {
        .stat-card h3 { font-size: 1.1rem; }
    }
</style>
@endsection