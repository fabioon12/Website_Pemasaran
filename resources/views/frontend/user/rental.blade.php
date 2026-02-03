@extends('layouts.user')

@section('title', 'My Archive Collections')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --archive-black: #1a1a1a;
        --archive-gray: #f8f9fa;
        --border-color: #eeeeee;
        --accent-unpaid: #dc3545;
        --accent-paid: #198754;
        --accent-verifying: #0d6efd;
    }

    body { background-color: #fff; font-family: 'Inter', sans-serif; color: var(--archive-black); }
    .page-header { padding: 60px 0 40px; border-bottom: 1px solid var(--border-color); margin-bottom: 40px; }
    .header-title { font-weight: 800; font-size: 2rem; letter-spacing: -1px; text-transform: uppercase; }

    /* --- Booking Card --- */
    .booking-card { border: 1px solid var(--border-color); border-radius: 0; margin-bottom: 25px; transition: all 0.3s ease; background: #fff; }
    .booking-card:hover { border-color: #000; transform: translateY(-2px); }
    .product-thumb { width: 120px; height: 160px; object-fit: cover; background-color: var(--archive-gray); }

    /* --- Status Badges --- */
    .status-badge { font-size: 0.65rem; font-weight: 800; padding: 6px 12px; text-transform: uppercase; letter-spacing: 1px; border-radius: 0; }
    .status-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .status-approved { background: #000; color: #fff; }
    .status-rejected { background: #fde2e2; color: #9b2c2c; border: 1px solid #feb2b2; }
    .status-returned { background: #f8f9fa; color: #6c757d; border: 1px solid #ddd; }

    /* --- Payment Labels --- */
    .payment-label { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 2px; margin-left: 10px; display: inline-flex; align-items: center; gap: 4px; vertical-align: middle; }
    .pay-unpaid { background: #fff5f5; color: var(--accent-unpaid); border: 1px solid #feb2b2; }
    .pay-paid { background: #f0fff4; color: var(--accent-paid); border: 1px solid #c6f6d5; }

    .booking-id-text { font-family: 'Monaco', 'Consolas', monospace; font-size: 0.75rem; color: #2563eb; background: #eff6ff; padding: 2px 8px; font-weight: 700; }
    .item-name { font-weight: 700; font-size: 1.1rem; text-transform: uppercase; margin-top: 5px; color: #000; text-decoration: none; }
    .info-label { font-size: 0.7rem; text-transform: uppercase; color: #888; font-weight: 700; display: block; }
    .info-value { font-size: 0.9rem; font-weight: 600; }

    /* --- WA Button --- */
    .btn-wa { background-color: #25D366; color: white; border: none; transition: 0.3s; }
    .btn-wa:hover { background-color: #128C7E; color: white; }
</style>

<div class="container mt-5 pb-5">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-md-6">
                <span class="text-muted small fw-bold text-uppercase">Member Dashboard</span>
                <h1 class="header-title">My Archive Requests</h1>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted small">Showing {{ $bookings->total() }} total collections</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            @forelse ($bookings as $booking)
                <div class="booking-card p-3 p-md-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @php
                                $images = is_array($booking->product->images) ? $booking->product->images : json_decode($booking->product->images, true);
                                $img = (!empty($images)) ? asset('storage/' . $images[0]) : 'https://via.placeholder.com/120x160';
                                
                                $formatted_id = '#B-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);

                                // Logic Pesan WhatsApp
                                $wa_number = "62895366602581"; 
                                $message = "Halo Admin, saya ingin konfirmasi pembayaran untuk booking " . $formatted_id . ".\n\n" .
                                           "Item: " . $booking->product->name . "\n" .
                                           "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n" .
                                           "Mohon segera diproses. Terima kasih.";
                                $wa_url = "https://wa.me/" . $wa_number . "?text=" . urlencode($message);
                            @endphp
                            <img src="{{ $img }}" class="product-thumb" alt="Item">
                        </div>

                        <div class="col">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="booking-id-text">{{ $formatted_id }}</span>
                                    
                                    @if(in_array($booking->status, ['approved', 'returned', 'completed']))
                                        @if($booking->status == 'returned' || $booking->status == 'completed')
                                            <span class="payment-label pay-paid"><i class="bi bi-patch-check-fill"></i> Paid</span>
                                        @else
                                            <span class="payment-label pay-unpaid"><i class="bi bi-exclamation-circle-fill"></i> Unpaid</span>
                                        @endif
                                    @endif

                                    <a href="{{ route('customer.user.rental.detail', $booking->id) }}" class="item-name d-block">{{ $booking->product->name }}</a>
                                </div>
                                
                                <span class="status-badge status-{{ $booking->status }}">
                                    {{ $booking->status }}
                                </span>
                            </div>

                            <div class="row mt-4">
                                <div class="col-6 col-md-3">
                                    <span class="info-label">Duration</span>
                                    <span class="info-value">{{ $booking->duration }} Weeks</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="info-label">Total Price</span>
                                    <span class="info-value text-dark fw-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-6 col-md-3 mt-3 mt-md-0">
                                    <span class="info-label">Date</span>
                                    <span class="info-value">{{ $booking->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="col-6 col-md-3 mt-3 mt-md-0 text-md-end d-flex gap-2 justify-content-end align-items-end">
                                    
                                    {{-- Tombol WhatsApp: Hanya Muncul Jika Status PENDING --}}
                                    @if($booking->status == 'pending')
                                        <a href="{{ $wa_url }}" target="_blank" class="btn btn-wa btn-sm rounded-0 px-3 fw-bold shadow-sm" title="Konfirmasi Pembayaran">
                                            <i class="bi bi-whatsapp me-1"></i> Confirm
                                        </a>
                                    @endif

                                    <a href="{{ route('customer.user.rental.detail', $booking->id) }}" class="btn btn-outline-dark btn-sm rounded-0 px-3 fw-bold small text-uppercase">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state text-center py-5">
                    <i class="bi bi-bag-x fs-1 mb-3 d-block text-muted"></i>
                    <h3 class="fw-bold">No archives yet</h3>
                    <a href="{{ route('customer.catalog.index') }}" class="btn btn-dark rounded-0 px-4 py-2 mt-3 uppercase small fw-bold">Browse Catalogue</a>
                </div>
            @endforelse
        </div>
    </div>
    
    <div class="pagination-wrapper mt-4 d-flex justify-content-center">
        {{ $bookings->links('pagination::bootstrap-5') }}
    </div>
@endsection