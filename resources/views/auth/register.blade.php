<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Archive & Rent</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .register-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .side-image-panel {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1000');
            background-size: cover;
            background-position: center;
        }

        .avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: #f8f9fa;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            z-index: 1;
        }

        .avatar-edit label {
            width: 30px;
            height: 30px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 16px;
            background-color: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: #000;
            box-shadow: none;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: none;
            border-radius: 12px 0 0 12px;
            color: #6c757d;
        }

        .btn-register {
            background: #000;
            color: #fff;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: #222;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .brand-logo { letter-spacing: -1px; font-weight: 800; }
        
        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #444;
            margin-bottom: 0.5rem;
            display: block;
        }

        .invalid-feedback {
            font-size: 0.7rem;
            margin-left: 5px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="card register-card animate__animated animate__zoomIn" style="max-width: 1000px; width: 100%;">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-flex side-image-panel text-white p-5 flex-column justify-content-between text-center">
                    <div>
                        <h1 class="brand-logo mb-0">ARCHIVE.</h1>
                        <p class="small opacity-75 text-uppercase">Sustainable Fashion</p>
                    </div>
                    <div>
                        <i class="bi bi-person-plus fs-1"></i>
                        <h2 class="fw-bold mt-3">Start Your Journey.</h2>
                        <p class="text-white-50 small">Join thousands of others archiving their style and renting their dreams.</p>
                    </div>
                    <div class="small opacity-50">
                        &copy; 2026 Archive. All rights reserved.
                    </div>
                </div>

                <div class="col-md-7 bg-white p-4 p-lg-5">
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark">Create Account</h2>
                        <p class="text-muted small">Fill in the details to get started.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4 text-center">
                            <div class="avatar-wrapper">
                                <div class="avatar-preview">
                                    <img id="imagePreview" src="https://ui-avatars.com/api/?name=User&background=f1f1f1&color=ccc" alt="Preview">
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg" class="d-none @error('avatar') is-invalid @enderror">
                                    <label for="imageUpload"><i class="bi bi-camera-fill small"></i></label>
                                </div>
                            </div>
                            @error('avatar') <div class="text-danger small mt-2" style="font-size: 0.7rem;">{{ $message }}</div> @enderror
                            <p class="text-muted mt-2" style="font-size: 0.7rem;">Profile Picture (Optional)</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Full Name</label>
                                <input type="text" name="name" class="form-control border-0 bg-light @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Email Address</label>
                                <input type="email" name="email" class="form-control border-0 bg-light @error('email') is-invalid @enderror" placeholder="name@email.com" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">No. WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-whatsapp"></i></span>
                                    <input type="tel" name="whatsapp" class="form-control border-0 bg-light @error('whatsapp') is-invalid @enderror" placeholder="0812..." value="{{ old('whatsapp') }}" required>
                                </div>
                                @error('whatsapp') <div class="text-danger small mt-1" style="font-size: 0.7rem;">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Instansi / Organisasi</label>
                                <input type="text" name="instansi" class="form-control border-0 bg-light @error('instansi') is-invalid @enderror" placeholder="Nama Kampus/Kantor" value="{{ old('instansi') }}" required>
                                @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Pekerjaan</label>
                            <select name="pekerjaan" class="form-select border-0 bg-light @error('pekerjaan') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih Status...</option>
                                <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="Dosen" {{ old('pekerjaan') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="Karyawan" {{ old('pekerjaan') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="Lainnya" {{ old('pekerjaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="passInput" class="form-control border-0 bg-light @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                    <span class="input-group-text bg-light border-0" style="cursor: pointer;" onclick="togglePass('passInput', 'icon1')">
                                        <i class="bi bi-eye-slash" id="icon1"></i>
                                    </span>
                                </div>
                                @error('password') <div class="text-danger small mt-1" style="font-size: 0.7rem;">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="confInput" class="form-control border-0 bg-light" placeholder="••••••••" required>
                                    <span class="input-group-text bg-light border-0" style="cursor: pointer;" onclick="togglePass('confInput', 'icon2')">
                                        <i class="bi bi-eye-slash" id="icon2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 mb-4 shadow-sm">
                            Create Account
                        </button>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Already have an account? 
                                <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageUpload').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById('imagePreview').src = URL.createObjectURL(file);
            }
        }

        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = "password";
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
</html>