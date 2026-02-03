
{{-- NAVIGATION --}}
<nav class="navbar navbar-expand-lg fixed-top shadow-none">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('customer.catalog.index') }}">
            <i class="bi bi-heart-fill me-1"></i> ARCHIVE & RENT
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex align-items-center gap-3 ms-auto">
                @guest
                    <a href="{{ route('login') }}" class="text-dark text-decoration-none small fw-bold me-2">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-0 px-4 btn-sm fw-bold">JOIN</a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none gap-2 dropdown-toggle shadow-none" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text-end d-none d-md-block">
                                <small class="d-block text-muted" style="font-size: 0.65rem;">Welcome back,</small>
                                <span class="small fw-bold text-dark">{{ Auth::user()->name }}</span>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=fff" class="nav-profile-img shadow-sm">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-3">
                            <li><a class="dropdown-item rounded-3 py-2 small" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item rounded-3 py-2 small" href="{{ route('customer.rental.index') }}"><i class="bi bi-bag-heart me-2"></i> My Wardrobe</a></li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 py-2 small text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>