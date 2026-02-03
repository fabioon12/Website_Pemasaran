<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="bi bi-heart"></i> Archive & Rent
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-4 mt-3 mt-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('/') ? 'fw-bold border-bottom border-dark' : '' }}" href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('catalog*') ? 'fw-bold border-bottom border-dark' : '' }}" href="{{ url('/catalog') }}">
                        Catalogue
                    </a>
                </li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a class="btn btn-dark px-4 rounded-pill btn-login" href="{{ url('/login') }}">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>