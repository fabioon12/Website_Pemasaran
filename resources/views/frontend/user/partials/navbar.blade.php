<style>
    /* 1. PERBAIKAN STRUKTURAL NAVBAR */
    nav.navbar.fixed-top {
        z-index: 9999 !important;
        position: fixed !important;
        /* Penting: Jangan gunakan overflow hidden di sini */
        overflow: visible !important; 
        height: var(--nav-height);
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* 2. PERBAIKAN DROPDOWN AGAR TIDAK TERPOTONG */
    .dropdown-menu {
        z-index: 10001 !important;
        /* Memastikan dropdown muncul di atas elemen Catalog manapun */
        display: none; 
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }

    .dropdown-menu.show {
        display: block;
    }

    /* 3. STYLING LINK & PROFILE */
    .nav-link-custom {
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6c757d;
        transition: 0.3s;
        letter-spacing: 0.5px;
    }

    .nav-link-custom:hover { color: #000; }

    .nav-link-custom.active {
        color: #000 !important;
        position: relative;
    }

    .nav-link-custom.active::after {
        content: "";
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #000;
    }

    .nav-profile-img { 
        width: 35px; 
        height: 35px; 
        object-fit: cover; 
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .dropdown-toggle::after { display: none; }
</style>

<nav class="navbar navbar-expand-lg fixed-top shadow-none bg-white">
    <div class="container d-flex justify-content-between align-items-center">
        
        <div class="d-flex align-items-center gap-4">
            <a class="navbar-brand fw-bold d-flex align-items-center me-0" href="{{ route('customer.home.index') }}">
                <i class="bi bi-heart me-2"></i> Archive & Rent
            </a>

            <div class="d-none d-md-flex align-items-center gap-3 ps-3 border-start">
                <a href="{{ route('customer.home.index') }}" 
                   class="nav-link-custom {{ Route::is('customer.home.index') ? 'active' : '' }}">HOME</a>
                
                <a href="{{ route('customer.catalog.index') }}" 
                   class="nav-link-custom {{ Route::is('customer.catalog.*') ? 'active' : '' }}">CATALOG</a>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            @guest
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="text-dark text-decoration-none small fw-bold px-2 py-1">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-0 px-3 py-1 btn-sm fw-bold">JOIN</a>
                </div>
            @else
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none gap-2 dropdown-toggle" 
                       id="userMenu" 
                       data-bs-toggle="dropdown" 
                       data-bs-display="static" 
                       aria-expanded="false">
                        
                        <div class="text-end d-none d-sm-block me-1">
                            <span class="small fw-bold text-dark d-block" style="line-height: 1;">{{ Auth::user()->name }}</span>
                            <small class="text-muted" style="font-size: 0.6rem; letter-spacing: 1px;">CUSTOMER</small>
                        </div>

                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=000&color=fff' }}" 
                             class="nav-profile-img" alt="Profile">
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 p-2 mt-2" aria-labelledby="userMenu">
                        <li class="d-md-none"><a class="dropdown-item rounded-2 py-2 small" href="{{ route('customer.home.index') }}">Home</a></li>
                        <li class="d-md-none"><a class="dropdown-item rounded-2 py-2 small" href="{{ route('customer.catalog.index') }}">Catalog</a></li>
                        <li class="d-md-none"><hr class="dropdown-divider opacity-50"></li>
                        
                        <li><a class="dropdown-item rounded-2 py-2 small" href="{{ route('customer.profil.index') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item rounded-2 py-2 small" href="{{ route('customer.rental.index') }}"><i class="bi bi-bag-heart me-2"></i> My Wardrobe</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-2 py-2 small text-danger fw-bold">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>