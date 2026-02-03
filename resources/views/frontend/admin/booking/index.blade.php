@extends('layouts.admin')

@section('title', 'Booking Management')

@section('admin-content')

<style>
   
    body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); }
    

    .header-title h2 { font-weight: 800; letter-spacing: -1px; color: var(--text-main); }
    .card { 
        border: 1px solid var(--border-color); 
        border-radius: 16px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.03); 
        transition: all 0.3s ease; 
        background: var(--bg-card);
    }
    .stat-card { border-left: 5px solid transparent; position: relative; overflow: hidden; }
    .stat-card.primary { border-left-color: #0d6efd; }
    .stat-card.success { border-left-color: #198754; }
    .stat-card.warning { border-left-color: #f59e0b; }
    
    .stat-icon { 
        width: 48px; height: 48px; border-radius: 12px; 
        display: flex; align-items: center; justify-content: center; 
        font-size: 1.25rem; flex-shrink: 0;
    }

    /* Table & Container */
    .table-container { 
        background: var(--bg-card); 
        border: 1px solid var(--border-color); 
        border-radius: 20px; 
    }
    
    /* tumpang tindih dropdown */
    .table-responsive { 
        overflow: visible !important; 
    }

    .table { color: var(--text-main); }
    .table thead th { 
        background-color: var(--bg-card); font-size: 0.75rem; 
        text-transform: none; font-weight: 700; color: var(--text-main);
        border-top: none; border-bottom: 1px solid var(--border-color); padding: 20px;
    }

    .table tbody td { 
        padding: 18px 20px; vertical-align: middle; 
        border-bottom: 1px solid var(--border-color); 
        color: var(--text-muted); 
    }

    /* Elements */
    .img-product { width: 42px; height: 56px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .avatar-client { width: 38px; height: 38px; border-radius: 10px; background: var(--bg-body); color: var(--accent-color); font-weight: 700; }
    .booking-id { font-family: 'Monaco', 'Consolas', monospace; color: #2563eb; background: rgba(37, 99, 235, 0.1); padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; }
    
    /* Status Badges */
    .badge-status {
        padding: 6px 16px; border-radius: 50px; font-size: 0.65rem; font-weight: 800;
        display: inline-flex; align-items: center; gap: 6px; letter-spacing: 0.3px;
    }
    .status-pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-approved { background: rgba(25, 135, 84, 0.1); color: #198754; border: 1px solid rgba(25, 135, 84, 0.2); }
    .status-returned { background: var(--bg-body); color: var(--text-muted); border: 1px solid var(--border-color); }

    /* Action Buttons */
    .btn-action { 
        width: 34px; height: 34px; border-radius: 8px; display: inline-flex; 
        align-items: center; justify-content: center; transition: 0.2s; 
        border: 1px solid var(--border-color); background: var(--bg-card);
        color: var(--text-main);
    }
    .btn-approve { background: #198754 !important; color: white !important; border: none; }
    .btn-reject { color: #dc3545; }
    .btn-more { color: var(--text-muted); }

    /* Dropdown Styling */
    .dropdown-menu { 
        background-color: var(--bg-card);
        border: 1px solid var(--border-color); 
        box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
        border-radius: 12px; padding: 8px; min-width: 180px; z-index: 1060;
    }
    .dropdown-item { 
        padding: 10px 12px; border-radius: 8px; font-size: 0.85rem; 
        font-weight: 500; display: flex; align-items: center; color: var(--text-main);
    }
    .dropdown-item i { font-size: 1.1rem; margin-right: 10px; }
    .dropdown-item:hover { background-color: var(--bg-body); color: var(--accent-color); }

    /* Search Bar */
    .search-input { 
        padding-left: 40px !important; border-radius: 10px; 
        border: 1px solid var(--border-color); background: var(--bg-body);
        color: var(--text-main);
    }

    @media (max-width: 768px) {
        .stat-card h3 { font-size: 1.25rem; }
    }
     /* Styling Payment Status yang Lebih Modern */
    .pay-badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.65rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.5px;
    }

    /* Status: Waiting */
    .pay-waiting {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px dashed rgba(108, 117, 125, 0.3);
    }

    /* Status: Belum Bayar */
    .pay-unpaid-new {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    /* Status: Sudah Bayar */
    .pay-paid-new {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div class="header-title">
            <h2 class="mb-1">Booking Reports</h2>
            <p class="text-muted small m-0 d-flex align-items-center">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i> Archive & Transaction Management
            </p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-sm px-3 rounded-3 fw-600 border" style="background: var(--bg-card); color: var(--text-main);">
                <i class="bi bi-printer me-2"></i>Print
            </button>
            <button onclick="exportBookingToExcel()" class="btn btn-dark btn-sm px-3 shadow-sm rounded-3 fw-600">
                <i class="bi bi-file-earmark-excel me-2"></i>Export
            </button>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card stat-card primary p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-bag-heart-fill"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; text-transform: uppercase;">Total Bookings</small>
                        <h3 class="fw-800 m-0">{{ $totalBookings ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card stat-card success p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; text-transform: uppercase;">Gross Revenue</small>
                        <h3 class="fw-800 m-0">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card stat-card warning p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-lightning-fill"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem; text-transform: uppercase;">Pending Approval</small>
                        <h3 class="fw-800 m-0">{{ $pendingCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="table-container shadow-sm mb-5">
        <div class="px-4 py-3 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <h6 class="m-0 fw-bold d-flex align-items-center"><i class="bi bi-clock-history me-2 text-muted"></i>Recent Transactions</h6>
            <div class="position-relative search-container" style="min-width: 280px;">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm search-input" placeholder="Search booking...">
            </div>
        </div>
        
        <div class="table-responsive">
            <table id="bookingTable" class="table table-hover m-0">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th width="150" class="text-end pe-4">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $item)
                    <tr>
                        <td class="text-center text-muted small">{{ $bookings->firstItem() + $index }}</td>
                        <td>
                            <span class="booking-id fw-bold">#B-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <div class="text-muted mt-1" style="font-size: 0.65rem;">{{ $item->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-client me-3 d-flex align-items-center justify-content-center">
                                    {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold small text-main">{{ $item->user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.65rem;">{{ $item->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $imgs = is_array($item->product->images) ? $item->product->images : json_decode($item->product->images, true);
                                    $firstImg = (!empty($imgs)) ? $imgs[0] : null;
                                    $finalUrl = ($firstImg && Storage::disk('public')->exists($firstImg)) ? asset('storage/' . $firstImg) : 'https://via.placeholder.com/100x130?text=No+Image';
                                @endphp
                                <img src="{{ $finalUrl }}" class="img-product">
                                <div>
                                    <div class="fw-bold small text-main">{{ $item->product->name }}</div>
                                    <span class="badge bg-light text-muted border fw-normal mt-1" style="font-size: 0.6rem;">
                                        {{ $item->duration }} Wk • Size {{ $item->product->size_label ?? 'M' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td><div class="fw-bold text-main">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div></td>
                        <td>
                            @if($item->status == 'pending')
                                <div class="pay-badge pay-waiting">
                                    <i class="bi bi-clock-history"></i>
                                    <span>WAITING APPROVED</span>
                                </div>
                            @elseif($item->status == 'approved')
                                <div class="pay-badge pay-unpaid-new">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span>UNPAID</span>
                                </div>
                            @elseif($item->status == 'returned')
                                <div class="pay-badge pay-paid-new">
                                    <i class="bi bi-check-all"></i>
                                    <span>PAID</span>
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status status-{{ strtolower($item->status) }}">
                                <i class="bi bi-{{ $item->status == 'pending' ? 'hourglass-split' : ($item->status == 'approved' ? 'check-all' : 'box-arrow-in-left') }}"></i>
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                @if($item->status == 'pending')
                                <form action="{{ route('admin.bookings.update-status', [$item->id, 'approved']) }}" method="POST" class="m-0 d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action btn-approve" title="Approve"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('admin.bookings.update-status', [$item->id, 'rejected']) }}" method="POST" class="m-0 d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action btn-reject" title="Reject"><i class="bi bi-x"></i></button>
                                </form>
                                @endif
                                
                                <div class="dropdown d-inline">
                                    <button class="btn-action btn-more" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                                        <li><a class="dropdown-item" href="{{ route('admin.bookings.detail', $item->id) }}"><i class="bi bi-eye"></i> View Details</a></li>
                                        @if($item->status == 'approved')
                                        <li>
                                            <form action="{{ route('admin.bookings.update-status', [$item->id, 'returned']) }}" method="POST" class="m-0">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="dropdown-item text-primary">
                                                    <i class="bi bi-box-seam"></i> Confirm Return
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash3"></i> Delete Log</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">No transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-3 d-flex flex-column flex-md-row justify-content-between align-items-center border-top">
            <div class="small text-muted mb-3 mb-md-0">
                Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
            </div>
            <div>
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#bookingTable tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    function exportBookingToExcel() {
        var table = document.getElementById("bookingTable");
        var wb = XLSX.utils.table_to_book(table, { sheet: "Reports" });
        XLSX.writeFile(wb, "Rental_Booking_Report.xlsx");
    }
</script>
@endsection