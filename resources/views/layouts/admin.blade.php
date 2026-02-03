<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sustainable Fashion Archive')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --accent-color: #000;
            --bg-body: #f8f9fa;
            --bg-card: #ffffff;
            --text-main: #1a1a1a;
            --text-muted: #666;
            --border-color: #eee;
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #1e1e1e;
            --text-main: #f8f9fa;
            --text-muted: #aaa;
            --border-color: #333;
            --accent-color: #fff;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main); 
            transition: background 0.3s ease; 
            margin: 0;
            overflow-x: hidden; /* Mencegah scroll horizontal saat sidebar keluar */
        }

        /* --- SIDEBAR CORE LOGIC --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0; /* Posisi awal: Masuk (Terlihat) */
            top: 0;
            background: var(--bg-card);
            border-right: 1px solid var(--border-color);
            z-index: 1100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Kondisi Keluar (Sembunyi) */
        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar-header { padding: 30px; border-bottom: 1px solid var(--border-color); }

        /* Nav Menu */
        .nav-admin { padding: 20px; }
        .nav-admin .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            transition: 0.3s;
            text-decoration: none;
        }

        .nav-admin .nav-link:hover, .nav-admin .nav-link.active {
            background: var(--bg-body);
            color: var(--accent-color);
            font-weight: 600;
        }

        /* --- MAIN CONTENT LOGIC --- */
        .main-content {
            margin-left: var(--sidebar-width); /* Margin awal sejauh sidebar */
            padding: 40px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        /* Saat sidebar keluar, konten melebar ke kiri */
        .main-content.expanded {
            margin-left: 0;
        }

        /* Top Bar */
        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            background: var(--bg-card);
            padding: 15px 25px;
            border-radius: 15px;
            border: 1px solid var(--border-color);
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); } /* Sembunyi di mobile */
            .sidebar.active { transform: translateX(0); } /* Muncul di mobile */
            .main-content { margin-left: 0; padding: 20px; }
            .main-content.expanded { margin-left: 0; }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-between">
            <a class="navbar-brand fw-bold fs-4 text-uppercase" href="#" style="color: var(--accent-color); letter-spacing: 2px;">
                <i class="bi bi-heart-fill"></i> Archive
            </a>
            <button class="btn d-lg-none border-0 text-muted" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="nav-admin">
            <a href="{{ route('admin.dashboard') }}" 
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <a href="{{ route('admin.produk.index') }}" 
            class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>

            <a href="{{ route('admin.booking.index') }}" class="nav-link {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Bookings
            </a>

            <!-- <a href="{{ route('admin.customer.dashboard') }}" class="nav-link {{ request()->routeIs('admin.customer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Customers
            </a> -->

            <hr style="border-color: var(--border-color); opacity: 0.1;">

            <a href="#" 
            class="nav-link text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
    </aside>

    <main class="main-content" id="main-content">
        <div class="admin-topbar shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <button class="btn border shadow-sm p-2" style="background: var(--bg-card); color: var(--text-main);" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h4 class="fw-bold mb-0 d-none d-md-block">Dashboard Overview</h4>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn border rounded-circle p-2 shadow-sm" style="background: var(--bg-card); color: var(--text-main);" id="theme-toggle" onclick="toggleTheme()">
                    <i class="bi bi-moon-stars" id="theme-icon"></i>
                </button>

                <div class="d-flex align-items-center gap-2 ps-3 border-start" style="border-color: var(--border-color) !important;">
                    <div class="text-end d-none d-sm-block">
                        <p class="fw-bold small mb-0">Admin</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=000&color=fff" class="rounded-circle" width="35" height="35">
                </div>
            </div>
        </div>

        <div class="container-fluid p-0">
            @yield('admin-content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            if (window.innerWidth > 991) {
                // Desktop: Sidebar geser ke kiri luar, Main Content margin jadi 0
                sidebar.classList.toggle('closed');
                mainContent.classList.toggle('expanded');
            } else {
                // Mobile: Sidebar muncul sebagai overlay
                sidebar.classList.toggle('active');
            }
        }

        function toggleTheme() {
            const body = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (body.getAttribute('data-theme') === 'dark') {
                body.setAttribute('data-theme', 'light');
                icon.classList.replace('bi-sun', 'bi-moon-stars');
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-theme', 'dark');
                icon.classList.replace('bi-moon-stars', 'bi-sun');
                localStorage.setItem('theme', 'dark');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                const icon = document.getElementById('theme-icon');
                if(icon) icon.classList.replace('bi-moon-stars', 'bi-sun');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: true, 
                confirmButtonText: 'OK', 
                confirmButtonColor: '#4ff31d', 
            });
        @endif

        // Notifikasi Error
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ $errors->first() }}",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#e30a0a',
            });
        @endif
    </script>

    <script>
        function confirmLogout(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Keluar dari aplikasi?',
                text: "Anda harus login kembali untuk mengakses katalog.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000', // Warna hitam sesuai tema Anda
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika klik OK, baru jalankan submit form
                    document.getElementById('logout-form').submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#000',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>