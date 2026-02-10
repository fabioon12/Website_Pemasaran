@extends('layouts.user')

@section('title', 'The Archive - Catalogue')

@section('content')
{{-- Link Bootstrap dihapus dari sini agar tidak menimpa layout --}}

<style>
    :root {
        --archive-black: #1a1a1a;
        --archive-gray: #f8f9fa;
        --archive-text-muted: #6c757d;
        --archive-border: #e0e0e0;
        --nav-height: 80px;
    }

    /* Padding top di sini bisa bentrok dengan layout, 
       disarankan hapus body style di sini jika layout sudah mengaturnya. 
       Namun jika ingin tetap ada, pastikan z-index navbar aman */
    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #fff; 
        color: var(--archive-black); 
    }

    /* --- Hero & Search --- */
    .hero-section { padding: 80px 0 40px; text-align: center; }
    .hero-title { font-size: 3.5rem; font-weight: 800; letter-spacing: -1px; text-transform: uppercase; margin-bottom: 5px; }
    .hero-subtitle { font-size: 0.85rem; color: var(--archive-text-muted); letter-spacing: 4px; text-transform: uppercase; margin-bottom: 25px; }
    
    .search-container { max-width: 500px; margin: 0 auto 30px; position: relative; }
    .search-input { 
        width: 100%; padding: 12px 20px; border: 1px solid var(--archive-border); border-radius: 0; 
        font-size: 0.8rem; letter-spacing: 1px; outline: none; transition: 0.3s;
    }
    .search-input:focus { border-color: #000; background: #fafafa; }

    /* --- Filter Section --- */
    .filter-wrapper {
        background: var(--archive-gray);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 40px;
        border: 1px solid #f0f0f0;
    }
    .filter-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; color: #888; display: block; }
    .filter-select {
        width: 100%; border: 1px solid #ddd; border-radius: 6px; padding: 10px;
        font-size: 0.85rem; cursor: pointer; transition: 0.2s;
    }

    /* --- Fashion Card & Slider Area --- */
    .fashion-card { border: none; background: none; margin-bottom: 35px; text-decoration: none; color: inherit; display: block; }
    
    .img-container { 
        position: relative; 
        width: 100%; 
        aspect-ratio: 3 / 4; 
        overflow: hidden; 
        background: #f8f8f8; 
        border-radius: 4px;
    }

    .carousel, .carousel-inner, .carousel-item { height: 100%; }
    .carousel-item img { 
        width: 100%; height: 100%; object-fit: cover; 
        transition: transform 1.2s cubic-bezier(0.2, 1, 0.3, 1); 
    }
    
    .fashion-card:hover .carousel-item.active img { transform: scale(1.08); }

    .carousel-control-prev, .carousel-control-next {
        width: 35px; height: 35px; background: rgba(255,255,255,0.9);
        border-radius: 50%; top: 50%; transform: translateY(-50%);
        opacity: 0; transition: 0.3s; color: #000; margin: 0 10px; z-index: 10; border: none;
    }
    .fashion-card:hover .carousel-control-prev, 
    .fashion-card:hover .carousel-control-next { opacity: 1; }
    .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1); width: 14px; }

    .rent-now-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.1);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.4s ease; z-index: 5;
    }
    .fashion-card:hover .rent-now-overlay { opacity: 1; }
    .btn-rent-overlay { 
        background: #fff; color: #000; padding: 12px 25px; font-size: 0.75rem; 
        font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: none;
    }

    .status-dot { width: 7px; height: 7px; background: #28a745; border-radius: 50%; display: inline-block; margin-right: 6px; }
    .reveal { opacity: 0; transform: translateY(30px); transition: 0.8s cubic-bezier(0.2, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

    .pagination-container { margin-top: 80px; padding-top: 40px; border-top: 1px solid var(--archive-border); }
</style>

<div class="container pb-5">
    <section class="hero-section">
        <h1 class="hero-title">The Archive</h1>
        <p class="hero-subtitle">Preserving Style • Sustaining Future</p>

        <form action="{{ route('customer.catalog.index') }}" method="GET" id="catalogForm">
            <div class="search-container">
                <input type="text" name="search" class="search-input" placeholder="SEARCH COLLECTION..." value="{{ request('search') }}">
                <button type="submit" class="position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h2 class="h6 fw-bold mb-0 text-uppercase" style="letter-spacing: 2px;">Catalogue</h2>
                <button class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2 px-3 py-2 rounded-0" 
                        type="button" data-bs-toggle="collapse" data-bs-target="#filterArea">
                    <i class="bi bi-funnel"></i> 
                    <span class="fw-bold" style="font-size: 0.75rem;">FILTERS</span>
                </button>
            </div>

            <div class="collapse {{ request()->anyFilled(['color', 'occasion', 'materials', 'year']) ? 'show' : '' }} mb-4" id="filterArea">
                <div class="filter-wrapper shadow-sm">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <label class="filter-label">Color</label>
                            <select name="color" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Colors</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="filter-label">Occasion</label>
                            <select name="occasion" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Occasions</option>
                                @foreach($occasions as $occ)
                                    <option value="{{ $occ }}" {{ request('occasion') == $occ ? 'selected' : '' }}>{{ ucfirst($occ) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="filter-label">Material</label>
                            <select name="materials" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Materials</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material }}" {{ request('materials') == $material ? 'selected' : '' }}>{{ strtoupper($material) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="filter-label">Year</label>
                            <select name="year" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Years</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="text-muted small">Showing <strong>{{ $products->total() }}</strong> Items</span>
                        <a href="{{ route('customer.catalog.index') }}" class="text-dark small fw-bold text-decoration-none">RESET FILTERS</a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3 reveal">
            <div class="fashion-card">
                <div id="slider-{{ $product->id }}" class="carousel slide img-container shadow-sm mb-3" data-bs-ride="false">
                    @php
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                        $images = !empty($images) ? $images : ['https://via.placeholder.com/600x800?text=No+Image'];
                    @endphp

                    <div class="carousel-inner">
                        @foreach($images as $idx => $img)
                        <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>

                    @if(count($images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#slider-{{ $product->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#slider-{{ $product->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    @endif

                    <div class="rent-now-overlay">
                        <a href="{{ route('customer.booking.show', $product->id) }}" class="btn-rent-overlay text-decoration-none">
                            {{ $product->stock > 0 ? 'Rent Now' : 'Waitlist' }}
                        </a>
                    </div>
                </div>

                <div class="text-start">
                    <h6 class="fw-bold text-uppercase mb-0" style="font-size: 0.85rem; letter-spacing: 0.5px;">{{ $product->name }}</h6>
                    <p class="text-muted mb-2" style="font-size: 0.75rem;">{{ $product->author ?? 'Archive Collection' }}</p>
                    
                    <div class="d-flex justify-content-between align-items-end pt-2 border-top">
                        <div>
                            <div class="text-muted small" style="font-size: 0.65rem;">{{ $product->year_made ?? 'N/A' }}</div>
                            <div class="fw-bold" style="font-size: 0.9rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>

                        <div class="text-end">
                            <div class="mb-1 d-flex align-items-center justify-content-end" style="font-size: 0.65rem; color: #666; font-weight: 700;">
                                <i class="bi bi-arrow-repeat me-1" style="font-size: 0.8rem; color: #000;"></i> 
                                <span>{{ $product->wear_count ?? 0 }} <span class="text-uppercase" style="font-size: 0.55rem; letter-spacing: 0.5px; font-weight: 400;">Worn</span></span>
                            </div>
                            
                            <div class="small fw-bold text-uppercase" style="font-size: 0.6rem;">
                                @if($product->stock > 0)
                                    <span class="status-dot"></span><span class="text-success">Available</span>
                                @else
                                    <span class="text-danger">Rented</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-archive text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">No products found in our archive.</p>
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="pagination-container d-flex justify-content-center">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@section('extra-js')
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('active'); }, index * 80);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection

@endsection