@extends('layouts.admin')

@section('title', 'Customer Management')

@section('admin-content')

<style>
    /* Global Style & Theme Adaptability */
    body { background-color: var(--bg-body); color: var(--text-main); }
    .card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; }
    
    /* Customer Card Style */
    .customer-table-container { border-radius: 20px; overflow: hidden; background: var(--bg-card); border: 1px solid var(--border-color); }
    
    /* Profile Circle */
    .customer-avatar {
        width: 45px; height: 45px; border-radius: 12px;
        background: linear-gradient(135deg, var(--accent-color) 0%, #444 100%);
        color: white; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.1rem;
    }

    /* Status Badges */
    .badge-user { padding: 5px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 600; }
    .status-active { background: rgba(25, 135, 84, 0.1); color: #198754; border: 1px solid rgba(25, 135, 84, 0.2); }
    
    /* Stats Info */
    .info-box { border-right: 1px solid var(--border-color); }
    .info-box:last-child { border-right: none; }
    
    /* Table Fix for Dark Mode */
    .table { color: var(--text-main); }
    .table thead th { 
        background-color: var(--bg-card); color: var(--text-main); 
        border-bottom: 2px solid var(--border-color); padding: 18px; font-size: 0.75rem;
    }
    .table tbody td { border-bottom: 1px solid var(--border-color); padding: 15px 18px; vertical-align: middle; }

    /* Action Buttons */
    .btn-action-view {
        background: var(--bg-body); border: 1px solid var(--border-color);
        color: var(--text-main); width: 36px; height: 36px; border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center; transition: 0.2s;
    }
    .btn-action-view:hover { background: var(--accent-color); color: var(--bg-card); }
</style>

<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-800 mb-1">Customer Insights</h2>
            <p class="text-muted small m-0"><i class="bi bi-people-fill me-2"></i>Manage and monitor your registered members.</p>
        </div>
        <div class="search-container position-relative" style="min-width: 300px;">
            <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
            <input type="text" class="form-control bg-card border-0 shadow-sm ps-5 py-2 rounded-3" 
                   placeholder="Search by name or email..." style="background: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color) !important;">
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <small class="text-muted fw-bold d-block mb-1">TOTAL CUSTOMERS</small>
                <h3 class="fw-800 m-0">1,240</h3>
                <span class="text-success small fw-bold mt-2 d-block"><i class="bi bi-graph-up-arrow"></i> +12% this month</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <small class="text-muted fw-bold d-block mb-1">ACTIVE RENTERS</small>
                <h3 class="fw-800 m-0">856</h3>
                <span class="text-muted small d-block mt-2">Currently have active bookings</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <small class="text-muted fw-bold d-block mb-1">AVG. SPENDING</small>
                <h3 class="fw-800 m-0">Rp 450k</h3>
                <span class="text-muted small d-block mt-2">Per transaction average</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <small class="text-muted fw-bold d-block mb-1">NEW MEMBERS</small>
                <h3 class="fw-800 m-0">24</h3>
                <span class="text-primary small fw-bold mt-2 d-block">Joined in last 7 days</span>
            </div>
        </div>
    </div>

    <div class="customer-table-container shadow-sm">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th class="text-center">Total Bookings</th>
                        <th class="text-center">Total Spend</th>
                        <th>Last Activity</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="customer-avatar me-3">JD</div>
                                <div>
                                    <div class="fw-bold text-main">John Doe</div>
                                    <div class="text-muted x-small" style="font-size: 0.75rem;">john.doe@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center fw-bold">12</td>
                        <td class="text-center">
                            <div class="fw-bold text-main">Rp 2.450.000</div>
                            <small class="text-muted" style="font-size: 0.65rem;">Top 5% Spender</small>
                        </td>
                        <td>
                            <div class="text-main small">Yesterday</div>
                            <div class="text-muted x-small" style="font-size: 0.7rem;">Rented: Black Suit XL</div>
                        </td>
                        <td><span class="badge-user status-active">ACTIVE</span></td>
                        <td class="text-end">
                            <button class="btn-action-view" title="View Profile"><i class="bi bi-eye"></i></button>
                            <button class="btn-action-view text-danger" title="Ban Account"><i class="bi bi-slash-circle"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="customer-avatar me-3" style="background: #eef2ff; color: #4f46e5;">SP</div>
                                <div>
                                    <div class="fw-bold text-main">Sarah Putri</div>
                                    <div class="text-muted x-small" style="font-size: 0.75rem;">sarah.p@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center fw-bold">3</td>
                        <td class="text-center">
                            <div class="fw-bold text-main">Rp 650.000</div>
                        </td>
                        <td>
                            <div class="text-main small">2 weeks ago</div>
                            <div class="text-muted x-small" style="font-size: 0.7rem;">Signed Up</div>
                        </td>
                        <td><span class="badge-user status-active">ACTIVE</span></td>
                        <td class="text-end">
                            <button class="btn-action-view" title="View Profile"><i class="bi bi-eye"></i></button>
                            <button class="btn-action-view text-danger" title="Ban Account"><i class="bi bi-slash-circle"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Showing 1 to 10 of 1,240 customers</small>
            <nav>
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                    <li class="page-item active"><a class="page-link" href="#" style="background: var(--accent-color); border: none;">1</a></li>
                    <li class="page-item"><a class="page-link" href="#" style="color: var(--text-main); background: var(--bg-card); border-color: var(--border-color);">2</a></li>
                    <li class="page-item"><a class="page-link" href="#" style="color: var(--text-main); background: var(--bg-card); border-color: var(--border-color);">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

@endsection