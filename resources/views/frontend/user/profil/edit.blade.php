@extends('layouts.app')

@section('title', 'The Archive - Edit Identity')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --archive-black: #000000;
        --archive-red: #e63946;
        --archive-gray: #fcfcfc;
        --archive-border: #eeeeee;
    }

    body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: var(--archive-black); }

    .header-section { padding: 60px 0 30px; text-align: center; }
    .header-title { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; }

    .form-container { max-width: 700px; margin: 0 auto; padding-bottom: 100px; }

    /* --- Form Styling --- */
    .form-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--archive-black);
        margin-bottom: 8px;
    }

    .form-control {
        border: none;
        border-bottom: 1px solid var(--archive-border);
        border-radius: 0;
        padding: 12px 0;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background-color: transparent;
    }

    .form-control:focus {
        box-shadow: none;
        border-bottom-color: var(--archive-black);
        background-color: transparent;
    }

    /* --- Avatar Upload --- */
    .avatar-upload-wrapper {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--archive-border);
        margin-bottom: 15px;
    }

    .custom-file-upload {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        color: var(--archive-red);
        text-decoration: underline;
    }

    /* --- Button Styling --- */
    .btn-save {
        background: var(--archive-black);
        color: #fff;
        border: none;
        border-radius: 0;
        padding: 15px 40px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: 0.3s;
        width: 100%;
    }

    .btn-save:hover {
        background: #333;
        color: #fff;
    }

    .input-group-text {
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--archive-border);
        border-radius: 0;
    }
</style>

<div class="container">
    <section class="header-section">
        <h1 class="header-title">Edit Identity</h1>
        <p class="text-muted small text-uppercase" style="letter-spacing: 4px;">Update your archive profile</p>
    </section>

    <div class="form-container">
        <form action="{{ route('customer.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- AVATAR UPLOAD --}}
            <div class="avatar-upload-wrapper">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=000&color=fff' }}" 
                     alt="Preview" class="avatar-preview" id="imagePreview">
                <br>
                <label for="avatar" class="custom-file-upload">Change Photo</label>
                <input type="file" name="avatar" id="avatar" class="d-none" onchange="previewImage(event)">
                @error('avatar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="row g-4">
                {{-- NAMA --}}
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- WHATSAPP --}}
                <div class="col-md-6">
                    <label class="form-label">WhatsApp Number</label>
                    <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp', $user->whatsapp) }}">
                    @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- PEKERJAAN --}}
                <div class="col-md-6">
                    <label class="form-label">Occupation / Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan', $user->pekerjaan) }}">
                    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- INSTANSI --}}
                <div class="col-12">
                    <label class="form-label">Institution / Instansi</label>
                    <input type="text" name="instansi" class="form-control @error('instansi') is-invalid @enderror" value="{{ old('instansi', $user->instansi) }}">
                    @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 mt-5">
                    <p class="small text-muted mb-4 border-bottom pb-2" style="letter-spacing: 1px;">SECURITY (LEAVE BLANK TO KEEP CURRENT PASSWORD)</p>
                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="col-md-6">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="mt-5 text-center">
                <button type="submit" class="btn-save mb-3">Save Changes</button>
                <br>
                <a href="{{ route('customer.profil.index') }}" class="text-muted small text-decoration-none fw-bold" style="letter-spacing: 1px;">CANCEL</a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection