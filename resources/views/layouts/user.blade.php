<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sustainable Fashion Archive')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
    :root {
        --nav-height: 70px;
    }

    body {
        padding-top: {{ Route::is('welcome') || Request::is('/') ? '0' : 'var(--nav-height)' }};
    }
    </style>
    @yield('extra-css')
</head>
<body>
    @include('frontend.user.partials.navbar')
    
    <main>
        @yield('content')
    </main>

    @include('frontend.user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inisialisasi Animasi
        AOS.init({
            duration: 1000,
            once: true,
            offset: 120
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#000', 
                timer: 5000, 
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    image: 'rounded-circle object-fit-cover border shadow-sm',
                    confirmButton: 'px-5 py-2 rounded-pill fw-bold' 
                },
                backdrop: `rgba(0,0,0,0.4)`
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
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
    @yield('extra-js')
</body>
</html>