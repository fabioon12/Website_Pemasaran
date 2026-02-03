@extends('layouts.user')

@section('title', 'Booking - ' . $product->name)

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --archive-black: #1a1a1a;
        --archive-gray: #f8f9fa;
        --archive-border: #e0e0e0;
        --nav-height: 80px;
    }

    body { 
        background-color: #ffffff; 
        font-family: 'Inter', sans-serif; 
        color: var(--archive-black);
        -webkit-font-smoothing: antialiased;
        padding-top: 40px; 
    }

    .back-link {
        display: inline-flex; align-items: center; text-decoration: none;
        color: #666; font-size: 0.85rem; font-weight: 600;
        margin-bottom: 30px; transition: 0.2s; text-transform: uppercase; letter-spacing: 1px;
    }
    .back-link:hover { color: #000; transform: translateX(-5px); }

    .image-wrapper {
        border-radius: 4px; overflow: hidden; background-color: #f9f9f9;
        position: sticky; top: 100px;
    }
    .product-image { width: 100%; height: auto; display: block; aspect-ratio: 3/4; object-fit: cover; }

    .product-title { font-weight: 800; font-size: 2.5rem; margin-bottom: 5px; letter-spacing: -1px; text-transform: uppercase; }
    .author-name { color: #888; font-size: 1rem; margin-bottom: 20px; display: block; letter-spacing: 1px; }
    
    .badge-status {
        font-size: 0.7rem; font-weight: 700; padding: 8px 16px;
        display: inline-block; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 2px;
    }
    .badge-available { background-color: #000; color: #fff; }
    .badge-unavailable { background-color: #dc3545; color: #fff; }

    .attr-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 25px;
        margin-bottom: 40px; padding: 25px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee;
    }
    .attr-item { display: flex; gap: 15px; align-items: center; }
    .attr-icon { color: #1a1a1a; font-size: 1.2rem; }
    .attr-label { font-size: 0.7rem; color: #888; text-transform: uppercase; font-weight: 700; margin-bottom: 2px; }
    .attr-value { font-size: 0.95rem; font-weight: 600; }

    .section-title { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; }
    .measurement-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 30px; }
    .measure-card { background: var(--archive-gray); padding: 15px; border-radius: 4px; display: flex; flex-direction: column; }
    .measure-label { font-size: 0.65rem; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 4px; }
    .measure-val { font-size: 1.1rem; font-weight: 700; }
    .measure-unit { font-size: 0.6rem; color: #bbb; margin-left: 2px; }

    .section-box { background-color: var(--archive-gray); padding: 25px; border-radius: 8px; margin-bottom: 30px; }
    .info-row { font-size: 0.9rem; display: flex; justify-content: space-between; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 10px; }

    .rental-card { margin-top: 40px; background: #fff; border: 2px solid #000; padding: 30px; }
    .rental-title { font-size: 1.25rem; font-weight: 800; text-transform: uppercase; margin-bottom: 25px; }
    
    .calendar-input {
        width: 100%; padding: 15px; border: 1px solid #000; border-radius: 0; font-weight: 600;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-calendar4' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z'/%3E%3C/svg%3E") no-repeat right 15px center;
        cursor: pointer;
    }

    .modal-content { border-radius: 20px !important; border: none; }
    .fw-800 { font-weight: 800; }
</style>

<div class="container pb-5 mt-5">
    <a href="{{ route('customer.catalog.index') }}" class="back-link">
        <i class="bi bi-arrow-left me-2"></i> Back to Catalogue
    </a>

    <div class="row g-5">
        {{-- LEFT COLUMN: IMAGE --}}
        <div class="col-lg-6">
            <div class="image-wrapper">
                @php
                    $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                    $firstImage = (is_array($images) && count($images) > 0) ? $images[0] : null;
                @endphp
                <img src="{{ $firstImage ? asset('storage/' . $firstImage) : 'https://via.placeholder.com/600x800' }}" class="product-image">
            </div>
        </div>

        {{-- RIGHT COLUMN: DETAILS --}}
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <h1 class="product-title">{{ $product->name }}</h1>
                <span class="author-name">{{ strtoupper($product->author ?? 'Archive Collection') }}</span>

                @if($product->stock > 0)
                    <div class="badge-status badge-available">Available for Archive</div>
                @else
                    <div class="badge-status badge-unavailable">Currently Unavailable</div>
                @endif

                <p class="product-description text-secondary mb-4">{{ $product->description }}</p>

                <div class="attr-grid">
                    <div class="attr-item">
                        <i class="bi bi-calendar3 attr-icon"></i>
                        <div><div class="attr-label">Year Made</div><div class="attr-value">{{ $product->year_made ?? 'N/A' }}</div></div>
                    </div>
                    <div class="attr-item">
                        <i class="bi bi-palette attr-icon"></i>
                        <div><div class="attr-label">Color</div><div class="attr-value">{{ ucfirst($product->color ?? 'N/A') }}</div></div>
                    </div>
                    <div class="attr-item">
                        <i class="bi bi-stars attr-icon"></i>
                        <div><div class="attr-label">Occasion</div><div class="attr-value">{{ ucfirst($product->occasion ?? 'N/A') }}</div></div>
                    </div>
                </div>

                <h3 class="section-title">Measurement Details</h3>
                <div class="measurement-grid">
                    <div class="measure-card">
                        <span class="measure-label">Bust</span>
                        <div><span class="measure-val">{{ $product->measure_bust ?? '--' }}</span><span class="measure-unit">cm</span></div>
                    </div>
                    <div class="measure-card">
                        <span class="measure-label">Waist</span>
                        <div><span class="measure-val">{{ $product->measure_waist ?? '--' }}</span><span class="measure-unit">cm</span></div>
                    </div>
                    <div class="measure-card">
                        <span class="measure-label">Hip</span>
                        <div><span class="measure-val">{{ $product->measure_hip ?? '--' }}</span><span class="measure-unit">cm</span></div>
                    </div>
                    <div class="measure-card">
                        <span class="measure-label">Length</span>
                        <div><span class="measure-val">{{ $product->measure_length ?? '--' }}</span><span class="measure-unit">cm</span></div>
                    </div>
                </div>

                <div class="section-box">
                    <h3 class="section-title">Technical Details</h3>
                    <div class="info-row">
                        <span class="text-muted">Material Composition</span>
                        <span class="fw-bold">{{ $product->materials ?? 'Premium Fabric' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="text-muted">Available Stock</span>
                        <span class="fw-bold">{{ $product->stock }} Units</span>
                    </div>
                </div>

                <div class="rental-card shadow-sm">
                    <h2 class="rental-title">Archive Request</h2>
                    
                    @if($product->stock > 0)
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Select Rental Dates (Range)</label>
                            <input type="text" id="dateRangePicker" class="calendar-input" placeholder="Pick your dates..." readonly>
                        </div>

                        <table class="w-100 mb-4">
                            <tr>
                                <td class="py-2 text-muted small">DURATION</td>
                                <td class="py-2 text-end fw-bold" id="durationDisplay">0 Weeks</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-muted small">WEEKLY RATE</td>
                                <td class="py-2 text-end fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr style="border-top: 2px solid #eee;">
                                <td class="pt-3 fw-bolder">ESTIMATED TOTAL</td>
                                <td class="pt-3 text-end fw-bolder fs-5" id="totalPriceDisplay">Rp 0</td>
                            </tr>
                        </table>

                        <button type="button" id="btnOpenModal" class="btn btn-dark btn-lg w-100 rounded-4 fw-bold py-3" 
                                data-bs-toggle="modal" data-bs-target="#rentNowModal" disabled>
                            RENT NOW <i class="bi bi-bag-plus ms-2"></i>
                        </button>
                    @else
                        <div class="text-center py-4 border border-dashed rounded-3 mb-3">
                            <i class="bi bi-slash-circle fs-2 text-muted mb-2 d-block"></i>
                            <p class="fw-bold text-uppercase mb-1">Stock Exhausted</p>
                            <span class="text-muted small">This archive item is currently being rented or out of stock.</span>
                        </div>
                        <button type="button" class="btn btn-secondary btn-lg w-100 rounded-4 fw-bold py-3" disabled style="opacity: 0.6;">
                            RENT UNAVAILABLE
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="rentNowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg bg-white text-dark">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-800">Finalize Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('customer.booking.store', $product->id) }}" method="POST">
                @csrf
                {{-- Data Hidden untuk dikirim ke Controller --}}
                <input type="hidden" name="start_date" id="start_date_input">
                <input type="hidden" name="end_date" id="end_date_input">
                <input type="hidden" name="duration" id="hiddenDurationInput">

                <div class="modal-body p-4 pt-0">
                    <div class="d-flex align-items-center p-3 mb-4 bg-light" style="border-radius: 16px;">
                        <img src="{{ $firstImage ? asset('storage/' . $firstImage) : '' }}" style="width: 60px; height: 80px; object-fit: cover; border-radius: 8px;">
                        <div class="ms-3 flex-grow-1">
                            <h6 class="fw-bold mb-0">{{ $product->name }}</h6>
                            <p class="text-muted small mb-0" id="modalDateRangeText">No dates selected</p>
                        </div>
                        <div class="text-end">
                            <span class="fw-800 fs-5" id="modalPriceLabel">Rp 0</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase opacity-75">Occasion (Acara)</label>
                            <input type="text" name="occasion" class="form-control border-0 shadow-sm p-3" 
                                   style="background: #f8f9fa; border-radius: 12px;" placeholder="e.g. Wedding" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase opacity-75">Tempat Acara</label>
                            <input type="text" name="venue" class="form-control border-0 shadow-sm p-3" 
                                   style="background: #f8f9fa; border-radius: 12px;" placeholder="Lokasi acara" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label small fw-bold text-uppercase text-danger">Syarat & Ketentuan</label>
                        <div class="p-3 bg-light rounded-3 small text-muted mb-2" style="height: 100px; overflow-y: auto;">
                            1. Barang dikembalikan dalam kondisi semula.<br>
                            2. Keterlambatan dikenakan denda Rp 50.000/hari.<br>
                            3. Kerusakan permanen wajib mengganti biaya perbaikan.
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label small text-muted" for="agreeTerms">Saya menyetujui S&K.</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small mb-0">Total Harga</p>
                            <h4 class="fw-800 mb-0" id="modalFooterPrice">Rp 0</h4>
                        </div>
                        <button type="submit" id="btnConfirmPay" class="btn btn-dark px-5 py-3 rounded-4 fw-bold" disabled>CONFIRM & PAY</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const basePrice = {{ $product->price }};
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const durationDisplay = document.getElementById('durationDisplay');
        const btnOpenModal = document.getElementById('btnOpenModal');
        
        const startInput = document.getElementById('start_date_input');
        const endInput = document.getElementById('end_date_input');
        const hiddenDurationInput = document.getElementById('hiddenDurationInput');
        const modalDateRangeText = document.getElementById('modalDateRangeText');
        const modalPriceLabel = document.getElementById('modalPriceLabel');
        const modalFooterPrice = document.getElementById('modalFooterPrice');

        const agreeTerms = document.getElementById('agreeTerms');
        const btnConfirmPay = document.getElementById('btnConfirmPay');

        // Flatpickr initialization
        if(document.getElementById('dateRangePicker')) {
            flatpickr("#dateRangePicker", {
                mode: "range",
                minDate: "today",
                dateFormat: "d M Y",
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length === 2) {
                        const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        const weeks = Math.ceil(diffDays / 7);
                        const total = basePrice * weeks;
                        const formatted = 'Rp ' + total.toLocaleString('id-ID');

                        durationDisplay.innerText = weeks + ' Week(s) (' + diffDays + ' Days)';
                        totalPriceDisplay.innerText = formatted;
                        btnOpenModal.disabled = false;

                        // Perbaikan ISO Date agar tidak bergeser tanggalnya
                        const start = new Date(selectedDates[0].getTime() - selectedDates[0].getTimezoneOffset() * 60000).toISOString().split('T')[0];
                        const end = new Date(selectedDates[1].getTime() - selectedDates[1].getTimezoneOffset() * 60000).toISOString().split('T')[0];

                        startInput.value = start;
                        endInput.value = end;
                        hiddenDurationInput.value = weeks;
                        
                        modalDateRangeText.innerText = dateStr;
                        modalPriceLabel.innerText = formatted;
                        modalFooterPrice.innerText = formatted;
                    } else {
                        btnOpenModal.disabled = true;
                    }
                }
            });
        }

        // Handle Checkbox S&K
        agreeTerms.addEventListener('change', function() {
            btnConfirmPay.disabled = !this.checked;
        });
    });
</script>
@endsection