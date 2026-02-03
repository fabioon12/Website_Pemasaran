@extends('layouts.app')

@section('title', 'The Archive - Catalogue')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --archive-black: #000000;
        --archive-red: #e63946; /* Warna merah aksen */
        --archive-gray: #fcfcfc;
        --archive-text-muted: #888888;
        --archive-border: #eeeeee;
        --transition-standard: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #ffffff; 
        color: var(--archive-black);
        -webkit-font-smoothing: antialiased;
    }

    /* --- Hero Section --- */
    .hero-section { padding: 80px 0 40px; text-align: center; }
    .hero-title { 
        font-family: 'Playfair Display', serif; 
        font-size: 4rem; 
        font-weight: 700; 
        letter-spacing: -2px; 
        margin-bottom: 10px; 
    }
    .hero-subtitle { 
        font-size: 0.75rem; 
        color: var(--archive-text-muted); 
        letter-spacing: 5px; 
        text-transform: uppercase; 
        font-weight: 600;
    }

    /* --- Search Bar --- */
    .search-container { max-width: 600px; margin: 40px auto; position: relative; }
    .search-input { 
        width: 100%; padding: 15px 25px; 
        border: none; border-bottom: 2px solid var(--archive-black);
        border-radius: 0; font-size: 0.9rem; letter-spacing: 1px; outline: none;
        transition: var(--transition-standard);
        text-align: center;
    }
    .search-input:focus { border-bottom-color: #888; }

    /* --- Filter Styling --- */
    .filter-btn {
        border: 1px solid var(--archive-black);
        border-radius: 0; font-size: 0.7rem; font-weight: 800;
        letter-spacing: 2px; text-transform: uppercase;
        padding: 10px 25px; transition: var(--transition-standard);
    }
    .filter-btn:hover { background: var(--archive-black); color: #fff; }

    .filter-wrapper {
        background: #fff; padding: 30px 0; margin-bottom: 20px;
        border-bottom: 1px solid var(--archive-border);
    }
    .filter-label { 
        font-size: 0.65rem; font-weight: 800; margin-bottom: 10px; 
        color: var(--archive-black); text-transform: uppercase; letter-spacing: 1.5px;
    }
    .filter-select {
        width: 100%; border: 1px solid var(--archive-border); border-radius: 0; padding: 12px;
        font-size: 0.8rem; color: #000; background-color: #fff;
        cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 15px center;
    }

    /* --- Product Card --- */
    .fashion-card { border: none; margin-bottom: 40px; text-decoration: none; color: inherit; display: block; }
    .img-container { 
        position: relative; width: 100%; aspect-ratio: 3/4;
        overflow: hidden; background: #fcfcfc; 
    }
    .img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .fashion-card:hover img { transform: scale(1.08); }

    .rent-now-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.4);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: var(--transition-standard); z-index: 2;
        backdrop-filter: blur(2px);
    }
    .fashion-card:hover .rent-now-overlay { opacity: 1; }
    .btn-rent-overlay { 
        background: #fff; color: #000; padding: 12px 24px; font-size: 0.7rem; 
        font-weight: 800; text-transform: uppercase; letter-spacing: 2px; border: none;
    }

    /* --- Wear Count Badge (UPDATED TO RED & RIGHT) --- */
    .wear-badge-red {
        color: var(--archive-red);
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 0;
        transition: all 0.3s ease;
    }
    .fashion-card:hover .wear-badge-red {
        transform: translateX(-3px);
    }

    /* --- Typography Info --- */
    .product-name { font-weight: 700; font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 15px; margin-bottom: 2px; }
    .product-author { font-size: 0.75rem; color: var(--archive-text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
    .product-meta { font-size: 0.65rem; color: #bbb; text-transform: uppercase; letter-spacing: 1px; }
    .product-price { font-weight: 700; font-size: 0.95rem; margin-top: 5px; }
    .status-dot { width: 6px; height: 6px; background: #28a745; border-radius: 50%; display: inline-block; margin-right: 5px; }

    /* --- Animation --- */
    .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease; }
    .reveal.active { opacity: 1; transform: translateY(0); }

    /* --- Pagination --- */
    .pagination-container { margin-top: 80px; padding-top: 40px; border-top: 1px solid var(--archive-border); }
    .pagination .page-item .page-link {
        background: transparent; border: 1px solid transparent; color: var(--archive-black);
        font-size: 0.75rem; font-weight: 700; padding: 8px 16px; text-transform: uppercase;
        letter-spacing: 1px; transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link { background-color: var(--archive-black); color: #fff; border-color: var(--archive-black); }
</style>

<div class="container pb-5">

    {{-- HERO & SEARCH --}}
    <section class="hero-section">
        <h1 class="hero-title">The Archive</h1>
        <p class="hero-subtitle">Preserving Style • Sustaining Future</p>

        <form action="{{ route('catalog.index') }}" method="GET" id="catalogForm">
            <div class="search-container">
                <input type="text" name="search" class="search-input" placeholder="SEARCH PIECES..." value="{{ request('search') }}">
                <button type="submit" class="position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h2 class="h6 fw-bolder mb-0 text-uppercase" style="letter-spacing: 3px; font-size: 0.7rem;">Collections / {{ $products->total() }}</h2>
                
                <button class="filter-btn d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#filterArea">
                    <i class="bi bi-sliders"></i> 
                    <span>Filters</span>
                </button>
            </div>

            <div class="collapse {{ request()->anyFilled(['color', 'occasion', 'materials', 'year']) ? 'show' : '' }} mb-4" id="filterArea">
                <div class="filter-wrapper">
                    <div class="row g-4">
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
                            <label class="filter-label">Archive Year</label>
                            <select name="year" class="filter-select" onchange="this.form.submit()">
                                <option value="">All Years</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('catalog.index') }}" class="text-muted small text-decoration-none fw-bold" style="letter-spacing: 1px;"><u>RESET ALL FILTERS</u></a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    {{-- PRODUCT GRID --}}
    <div class="row g-4 g-lg-5">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3 reveal">
            <a href="{{ route('login') }}" class="fashion-card">
                <div class="img-container">
                    @php
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                        $imageUrl = (!empty($images) && isset($images[0])) 
                                    ? asset('storage/' . $images[0]) 
                                    : 'https://via.placeholder.com/600x800?text=No+Image';
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" loading="lazy">
                    <div class="rent-now-overlay">
                        <span class="btn-rent-overlay">Rent Piece</span>
                    </div>
                </div>

                <div class="text-start mt-3">
                    <h6 class="product-name">{{ $product->name }}</h6>
                    <p class="product-author">{{ $product->author ?? 'Archive Collection' }}</p>
                    
                    <div class="product-meta d-flex justify-content-between align-items-center border-top pt-2">
                        {{-- KIRI: Tahun & Status --}}
                        <div>
                            <span style="color: #999;">EST. {{ $product->year_made ?? 'N/A' }}</span>
                            @if($product->stock > 0)
                                <span class="text-success ms-2" style="font-size: 0.6rem; font-weight: 700;">
                                    <span class="status-dot"></span>AVAILABLE
                                </span>
                            @endif
                        </div>

                        {{-- KANAN: Wear Count (WARNA MERAH) --}}
                        <span class="wear-badge-red" title="Total Wears">
                            <i class="bi bi-arrow-repeat"></i> 
                            {{ $product->bookings_count ?? 0 }} WEARS
                        </span>
                    </div>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted text-uppercase small ls-2">No pieces found in current archive.</p>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($products->hasPages())
        <div class="pagination-container d-flex justify-content-center">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('active');
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endsection