<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sustainable Fashion Archive')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      body { font-family: 'Inter', sans-serif; color: #333; }
        
        /* Navbar & Hamburger Only */
        .navbar-toggler {
            padding: 0; width: 30px; height: 30px; position: relative;
            transition: .5s ease-in-out; cursor: pointer;
        }
        .navbar-toggler span {
            display: block; position: absolute; height: 2px; width: 100%;
            background: #000; border-radius: 9px; transition: .25s ease-in-out;
        }
        .navbar-toggler span:nth-child(1) { top: 6px; }
        .navbar-toggler span:nth-child(2) { top: 14px; }
        .navbar-toggler span:nth-child(3) { top: 22px; }
        .navbar-toggler[aria-expanded="true"] span:nth-child(1) { top: 14px; transform: rotate(135deg); }
        .navbar-toggler[aria-expanded="true"] span:nth-child(2) { opacity: 0; left: -40px; }
        .navbar-toggler[aria-expanded="true"] span:nth-child(3) { top: 14px; transform: rotate(-135deg); }

        @media (max-width: 991.98px) {
            .navbar-collapse { background-color: white; padding: 20px 0; text-align: center; }
        }

        footer { border-top: 1px solid #eee; padding: 40px 0; font-size: 0.7rem; letter-spacing: 1px; color: #888; }
    </style>
    @yield('extra-css')
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Animasi
        AOS.init({
            duration: 1000,
            once: true,
            offset: 120
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil Masuk!',
                text: "{{ session('success') }}",
                imageUrl: "{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=000&color=fff' }}",
                imageWidth: 100,
                imageHeight: 100,
                imageAlt: 'User Avatar',
                
            
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#000', // Warna hitam sesuai tema
                
                timer: 5000, // Durasi sedikit lebih lama agar user sempat klik
                timerProgressBar: true,
                
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    image: 'rounded-circle object-fit-cover border shadow-sm',
                    confirmButton: 'px-5 py-2 rounded-pill fw-bold' // Membuat tombol lonjong (pill)
                },
                backdrop: `rgba(0,0,0,0.4)`
            });
        @endif

   
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Login',
                text: "{{ $errors->first() }}",
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#000',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'px-4 py-2 rounded-pill'
                }
            });
        @endif
    </script>
</body>
</html>