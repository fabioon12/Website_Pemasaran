@extends('layouts.user')

@section('title', 'Booking Detail - #' . str_pad($booking->id, 5, '0', STR_PAD_LEFT))

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
    .detail-container { padding: 60px 0; }
    
    .status-banner {
        padding: 20px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        font-size: 0.8rem;
        margin-bottom: 40px;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #000; color: #fff; }
    .status-returned { background: #f8f9fa; color: #6c757d; border: 1px solid var(--border-color); }

    .section-title {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #999;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }

    .info-group { margin-bottom: 25px; }
    .info-label { font-size: 0.75rem; color: #888; text-transform: uppercase; display: block; margin-bottom: 2px; }
    .info-value { font-size: 1rem; font-weight: 600; }

    .product-box {
        border: 1px solid var(--border-color);
        padding: 25px;
        display: flex;
        gap: 25px;
        background: #fff;
    }

    .product-img {
        width: 120px;
        height: 160px;
        object-fit: cover;
        border-radius: 2px;
    }

    .tech-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        background: var(--archive-gray);
        padding: 25px;
        margin-bottom: 40px;
    }

    /* --- Measurement Styling --- */
    .measurement-grid {
        background: #fff;
        border: 1px dashed #ccc;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 20px;
        padding: 25px;
        margin-bottom: 40px;
    }

    .measure-item {
        display: flex;
        flex-direction: column;
        border-left: 2px solid var(--archive-black);
        padding-left: 15px;
    }

    .measure-val {
        font-size: 1.2rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        color: #000;
    }

    .measure-icon {
        font-size: 0.7rem;
        font-weight: 800;
        color: #999;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .price-table td { padding: 12px 0; font-size: 0.9rem; }
    .total-row { border-top: 2px solid #000; font-weight: 800; font-size: 1.1rem; }

    .bank-box {
        background: #f1f1f1;
        padding: 15px;
        margin-top: 15px;
        border-radius: 4px;
    }
      .navbar {
        height: var(--nav-height);
        background: rgba(255, 255, 255, 0.8) !important; /* Transparan sedikit */
        backdrop-filter: blur(15px); /* Efek blur kaca modern */
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-size: 1.1rem;
        letter-spacing: 1px;
        color: var(--archive-black) !important;
    }

    .nav-profile-img {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .dropdown-menu {
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        border-radius: 12px !important;
        margin-top: 15px !important;
    }
</style>

<div class="container detail-container mt-5 pb-5">
    {{-- Breadcrumb --}}
    <a href="{{ route('customer.rental.index') }}" class="text-decoration-none text-dark small fw-bold text-uppercase mb-4 d-inline-block">
        <i class="bi bi-arrow-left"></i> Back to My Archives
    </a>

    <div class="row">
        <div class="col-lg-8">
            {{-- Status Banner --}}
            <div class="status-banner status-{{ $booking->status }}">
                Order Status: {{ $booking->status }}
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="fw-800 text-uppercase mb-1">Archive Receipt</h2>
                    <p class="text-muted small">ID: #ARC-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small text-muted mb-0 uppercase">Rental Period</p>
                    <p class="fw-bold">
                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} 
                        <span class="text-muted mx-1">—</span> 
                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                    </p>
                    <p class="small text-muted mb-0 mt-2 uppercase">Order Placed On</p>
                    <p class="small fw-medium">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Main Product Info --}}
            <h3 class="section-title">Item Summary</h3>
            <div class="product-box mb-4">
                @php
                    $images = is_array($booking->product->images) ? $booking->product->images : json_decode($booking->product->images, true);
                    $img = (!empty($images)) ? asset('storage/' . $images[0]) : 'https://via.placeholder.com/120x160';
                    // Simulasi status sebelum backend siap
                    $temp_payment_status = $booking->payment_status ?? 'unpaid';
                @endphp
                <img src="{{ $img }}" class="product-img shadow-sm" alt="">
                <div>
                    <span class="text-muted small text-uppercase letter-spacing-1">{{ $booking->product->author ?? 'Archive Collection' }}</span>
                    <h4 class="fw-bold text-uppercase mt-1 mb-3">{{ $booking->product->name }}</h4>
                    <p class="small text-muted mb-0 italic">"{{ $booking->product->description }}"</p>
                </div>
            </div>

            {{-- Technical Specifications --}}
            <h3 class="section-title">Technical Specifications</h3>
            <div class="tech-grid">
                <div class="info-group mb-0">
                    <span class="info-label">Material</span>
                    <span class="info-value">{{ $booking->product->materials ?? 'N/A' }}</span>
                </div>
                <div class="info-group mb-0">
                    <span class="info-label">Primary Color</span>
                    <span class="info-value">{{ ucfirst($booking->product->color ?? 'N/A') }}</span>
                </div>
            </div>

            {{-- Measurement Details --}}
            <h3 class="section-title">Measurement Details (CM)</h3>
            
            <div class="measurement-grid">
                <div class="measure-item">
                    <div class="measure-icon"><i class="bi bi-arrows-expand"></i> BUST</div>
                    <span class="measure-val">{{ $booking->product->measure_bust ?? '--' }}</span>
                    <span class="info-label">Centimeters</span>
                </div>
                
                <div class="measure-item">
                    <div class="measure-icon"><i class="bi bi-arrows-collapse"></i> WAIST</div>
                    <span class="measure-val">{{ $booking->product->measure_waist ?? '--' }}</span>
                    <span class="info-label">Centimeters</span>
                </div>

                <div class="measure-item">
                    <div class="measure-icon"><i class="bi bi-intersect"></i> HIP</div>
                    <span class="measure-val">{{ $booking->product->measure_hip ?? '--' }}</span>
                    <span class="info-label">Centimeters</span>
                </div>

                <div class="measure-item">
                    <div class="measure-icon"><i class="bi bi-arrow-down-up"></i> LENGTH</div>
                    <span class="measure-val">{{ $booking->product->measure_length ?? '--' }}</span>
                    <span class="info-label">Centimeters</span>
                </div>
            </div>

            {{-- Financial Summary --}}
            <h3 class="section-title">Financial Summary</h3>
            <table class="w-100 price-table mb-5">
                <tr>
                    <td class="text-muted">Weekly Base Rate</td>
                    <td class="text-end">Rp {{ number_format($booking->product->price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Duration ({{ $booking->duration }} Weeks)</td>
                    <td class="text-end">Rp {{ number_format($booking->product->price * $booking->duration, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td class="pt-3">TOTAL AMOUNT</td>
                    <td class="pt-3 text-end text-dark">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4 ps-lg-5">
            <div class="p-4 bg-light shadow-sm">
                <h3 class="section-title border-dark">Administrative Action</h3>

                @if($booking->status == 'pending')
                    <p class="small text-muted mb-4">Your request is currently in queue. Payment details will appear here once our curators approve your request.</p>
                    <div class="d-flex align-items-center gap-2 text-warning small fw-bold uppercase">
                        <i class="bi bi-clock-history"></i> Awaiting Verification
                    </div>

                @elseif($booking->status == 'approved')
                    
                    @if($temp_payment_status == 'unpaid')
                        <div class="mb-4">
                            <span class="badge bg-danger rounded-0 mb-2 uppercase" style="font-size: 0.6rem">Payment Required</span>
                            <p class="small text-muted mb-3">Your request has been approved. Please complete the transfer to confirm your rental.</p>
                            
                            <div class="bank-box mb-3">
                                <span class="info-label">Bank Central Asia (BCA)</span>
                                <span class="fw-bold d-block">8830 2931 11</span>
                                <span class="small text-muted">A/N ARCHIVE COLLECTION</span>
                            </div>

                            <button class="btn btn-dark w-100 rounded-0 py-2 small fw-bold text-uppercase" data-bs-toggle="modal" data-bs-target="#payModal">
                                Upload Proof of Payment
                            </button>
                        </div>
                    @elseif($temp_payment_status == 'verifying')
                        <div class="text-center py-3">
                            <i class="bi bi-search fs-3 text-primary"></i>
                            <p class="small fw-bold mt-2 mb-0">PAYMENT VERIFYING</p>
                            <p class="small text-muted">We are currently checking your transaction.</p>
                        </div>
                    @else
                        <div class="bg-dark text-white p-3 text-center mb-4">
                            <i class="bi bi-qr-code fs-1"></i>
                            <p class="small fw-bold mt-2 mb-0">PICKUP CODE</p>
                            <h5 class="fw-800">ARC-{{ $booking->id }}</h5>
                        </div>
                        <p class="small text-muted">Show this code at the gallery to collect your item.</p>
                    @endif

                @endif
                
                <hr class="my-4">
                
                <h3 class="section-title">Care Instructions</h3>
                <ul class="list-unstyled small text-muted">
                    <li class="mb-2"><i class="bi bi-shield-check me-2"></i> No home washing allowed</li>
                    <li class="mb-2"><i class="bi bi-shield-check me-2"></i> Avoid direct perfume contact</li>
                    <li class="mb-2"><i class="bi bi-shield-check me-2"></i> Professional cleaning included</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Static Pay Modal --}}
<div class="modal fade" id="payModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-uppercase small mb-0">Submit Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3">Ensure the receipt shows the date, total amount, and destination account.</p>
                <div class="mb-3">
                    <label class="info-label mb-1">Receipt Image (JPG/PNG)</label>
                    <input type="file" class="form-control rounded-0">
                </div>
                <button type="button" class="btn btn-dark w-100 rounded-0 fw-bold py-2 text-uppercase small" onclick="alert('Submit feature will be active once backend is connected.')">
                    Confirm Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection