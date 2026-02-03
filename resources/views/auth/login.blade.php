<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Welcome - Sustainable Fashion Archive</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-vh-100;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .side-image-panel {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1000');
            background-size: cover;
            background-position: center;
        }

        .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            background-color: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #000;
            box-shadow: none;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
            color: #6c757d;
        }

        .btn-login {
            background: #000;
            color: #fff;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #222;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .brand-logo {
            letter-spacing: -1px;
            font-weight: 800;
        }

        /* Float Animation */
        .floating-icon {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-card animate__animated animate__zoomIn" style="max-width: 1000px;">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-flex side-image-panel text-white p-5 flex-column justify-content-between text-center">
                    <div>
                        <h1 class="brand-logo mb-0">ARCHIVE.</h1>
                        <p class="small opacity-75">SUSTAINABLE FASHION</p>
                    </div>
                    
                    <div class="floating-icon">
                        <i class="bi bi-bag-heart fs-1"></i>
                        <h2 class="fw-bold mt-3">Style is Eternal.</h2>
                        <p class="text-white-50">Join our movement in circular fashion.</p>
                    </div>

                    <div class="small opacity-50">
                        &copy; 2024 Archive Archive. All rights reserved.
                    </div>
                </div>
                
                <div class="col-md-7 bg-white p-4 p-lg-5">
                    <div class="mb-5">
                        <h2 class="fw-extrabold text-dark">Welcome Back</h2>
                        <p class="text-muted">Please enter your details to sign in.</p>
                    </div>

                    <form action="{{ route('login.store') }}" method="POST" id="loginForm">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 small">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="form-control border-0 bg-light" placeholder="name@company.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="passwordInput"
                                       class="form-control border-0 bg-light" placeholder="••••••••" required>
                                <span class="input-group-text bg-light border-0" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Keep me logged in</label>
                            </div>
                            <a href="#" class="text-decoration-none small fw-bold text-dark">Reset Password?</a>
                        </div>

                        <button type="submit" class="btn btn-login w-100 mb-4">
                            Sign In
                        </button>

                        <div class="text-center">
                            <p class="small text-muted">New here? <a href="{{ route('register') }}" class="text-dark fw-bold text-decoration-none">Create an account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>