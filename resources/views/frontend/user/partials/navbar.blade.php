<nav class="navbar fixed-top shadow-none">
    <div class="container d-flex justify-content-between align-items-center">
        {{-- LOGO --}}
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('customer.catalog.index') }}">
            <i class="bi bi-heart"></i> Archive & Rent
        </a>
        
        {{-- MENU LANGSUNG (TANPA COLLAPSE) --}}
        <div class="d-flex align-items-center">
            @guest
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="text-dark text-decoration-none small fw-bold px-2 py-1">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-0 px-3 py-1 btn-sm fw-bold">JOIN</a>
                </div>
            @else
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none gap-2 dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end d-none d-sm-block me-1">
                            <span class="small fw-bold text-dark d-block" style="line-height: 1;">{{ Auth::user()->name }}</span>
                            <small class="text-muted" style="font-size: 0.6rem; letter-spacing: 1px;">CUSTOMER</small>
                        </div>
                        
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=000&color=fff' }}" 
                             class="nav-profile-img" alt="Profile">
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-2" style="min-width: 200px; border-radius: 12px !important;">
                        <li>
                            <div class="px-3 py-2 d-sm-none border-bottom mb-2">
                                <span class="fw-bold d-block">{{ Auth::user()->name }}</span>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </li>
                        <li><a class="dropdown-item rounded-2 py-2 small" href="{{ route('customer.profil.index') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item rounded-2 py-2 small" href="#"><i class="bi bi-bag-heart me-2"></i> My Wardrobe</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-2 py-2 small text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>