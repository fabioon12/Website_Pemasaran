@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('admin-content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-800 mb-0">BOOKING DETAIL</h2>
            <p class="text-muted">Transaction ID: #INV-{{ $booking->id }}-{{ date('Y') }}</p>
        </div>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="row g-4">
        {{-- INFO PRODUK & CUSTOMER --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
                <div class="d-flex align-items-start gap-4">
                    @php 
                        $images = is_string($booking->product->images) ? json_decode($booking->product->images, true) : $booking->product->images;
                        $firstImage = (is_array($images) && count($images) > 0) ? $images[0] : null;
                    @endphp
                    <img src="{{ asset('storage/' . $firstImage) }}" class="rounded shadow-sm" style="width: 120px; height: 160px; object-fit: cover;">
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold text-uppercase mb-1">{{ $booking->product->name }}</h4>
                            <span class="badge {{ $booking->status == 'pending' ? 'bg-warning' : 'bg-success' }} text-uppercase px-3 py-2">
                                {{ $booking->status }}
                            </span>
                        </div>
                        <p class="text-muted mb-3">{{ $booking->product->author ?? 'Archive Collection' }}</p>
                        
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block text-uppercase">Start Date</small>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</span>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block text-uppercase">End Date</small>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block text-uppercase">Duration</small>
                                <span class="fw-bold">{{ $booking->duration }} Week(s)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT DETAILS --}}
            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <h5 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Event Information</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase mb-1">Occasion / Event</small>
                            <p class="fw-bold mb-0">{{ $booking->occasion }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase mb-1">Venue Location</small>
                            <p class="fw-bold mb-0">{{ $booking->venue }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO PEMBAYARAN & USER --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px; background-color: #1a1a1a; color: white;">
                <h6 class="text-uppercase small mb-4 opacity-75">Customer Profile</h6>
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                    </div>
                    <div class="ms-3">
                        <p class="mb-0 fw-bold">{{ $booking->user->name }}</p>
                        <p class="small opacity-75 mb-0">{{ $booking->user->email }}</p>
                    </div>
                </div>
                <hr class="opacity-25">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small opacity-75">TOTAL PAYMENT</span>
                    <h3 class="fw-800 mb-0 text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                <small class="text-muted d-block mb-2">Internal Note:</small>
                <p class="small text-muted italic mb-0">Booking ini dibuat pada {{ $booking->created_at->format('d/m/Y H:i') }}. Pastikan barang sudah disiapkan 1 hari sebelum tanggal sewa dimulai.</p>
            </div>
        </div>
    </div>
</div>
@endsection