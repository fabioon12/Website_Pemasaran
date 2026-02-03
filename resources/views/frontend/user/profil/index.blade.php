@extends('layouts.user')

@section('title', 'The Archive - My Profile')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --archive-black: #000000;
        --archive-red: #e63946;
        --archive-gray: #f9f9f9;
        --archive-border: #eeeeee;
    }

    body { font-family: 'Inter', sans-serif; background-color: #fff; }

    .profile-header { padding: 60px 0 40px; text-align: center; }
    .profile-title { 
        font-family: 'Playfair Display', serif; 
        font-size: 3rem; 
        font-weight: 700; 
        letter-spacing: -1px; 
    }

    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .avatar-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 30px;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid var(--archive-border);
        padding: 5px;
    }

    .info-card {
        border: 1px solid var(--archive-border);
        padding: 30px;
        background: #fff;
    }

    .info-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #999;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--archive-black);
        margin-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .action-btn {
        display: inline-block;
        border: 1px solid var(--archive-black);
        background: transparent;
        color: var(--archive-black);
        padding: 12px 30px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-decoration: none;
        transition: 0.3s;
        margin-top: 20px;
    }

    .action-btn:hover {
        background: var(--archive-black);
        color: #fff;
    }

    .badge-customer {
        background: var(--archive-black);
        color: #fff;
        font-size: 0.6rem;
        padding: 4px 12px;
        letter-spacing: 2px;
        vertical-align: middle;
    }
</style>

<div class="container pb-5">
    <section class="profile-header">
        <h1 class="profile-title">Identity</h1>
        <p class="text-muted small text-uppercase ls-3" style="letter-spacing: 5px;">Member of The Archive</p>
    </section>

    <div class="profile-container">
        <div class="reveal active">
            <div class="avatar-wrapper">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=000&color=fff' }}" 
                     alt="Profile Picture" class="avatar-img">
            </div>

            <div class="info-card">
                <div class="row">
                    <div class="col-md-6">
                        <label class="info-label">Full Name</label>
                        <div class="info-value">
                            {{ Auth::user()->name }} 
                            <span class="badge badge-customer ms-2">CUSTOMER</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label">Email Address</label>
                        <div class="info-value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label">WhatsApp</label>
                        <div class="info-value">{{ Auth::user()->whatsapp }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="info-label">Occupation / Pekerjaan</label>
                        <div class="info-value">{{ Auth::user()->pekerjaan }}</div>
                    </div>
                    <div class="col-md-12">
                        <label class="info-label">Institution / Instansi</label>
                        <div class="info-value">{{ Auth::user()->instansi }}</div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('customer.profil.edit') }}" class="action-btn">Edit Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="action-btn border-danger text-danger bg-white ms-md-2" style="border-color: #e63946 !important;">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-5 text-center">
                <a href="{{ route('customer.catalog.index') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i>RETURN TO CATALOGUE
                </a>
            </div>
        </div>
    </div>
</div>
@endsection