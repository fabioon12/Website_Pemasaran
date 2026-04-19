<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\logincontroller;
use App\Http\Controllers\auth\registercontroller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardbokingController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\BookingController;
USE App\Http\Controllers\Customer\ProfilController;
use App\Http\Controllers\landingpage\CataloglandingController;
use App\Http\Controllers\CustomerdashboardController;
use App\Http\Controllers\Admin\MateriController as MateriAdminController;
use App\Http\Controllers\Admin\SubmateriController as SubmateriAdminController;
use App\Http\Controllers\Customer\MatapelajaranController;



// Authentication Routes
Route::middleware(['redirectIfAuthenticated'])->group(function () {
    Route::get('/', function () {
        return view('landingpage.welcome');
    })->name('welcome');

    Route::get('/catalog', [CataloglandingController::class, 'index'])->name('catalog.index');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Admin & Customer Routes
Route::middleware(['auth', 'role:ADMINISTRATOR'])->group(function () {
    // dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('admin')->middleware(['auth', 'role:ADMINISTRATOR'])->group(function () {
    // produk
    Route::get('produk', [ProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('produk/create', [ProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('produk/store', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('produk/{id}/update', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('produk/{id}/destroy', [ProdukController::class, 'destroy'])->name('admin.produk.destroy');
    // booking
    Route::get('booking', [DashboardbokingController::class, 'index'])->name('admin.booking.index');
    Route::patch('/admin/bookings/{id}/{status}', [DashboardbokingController::class, 'updateStatus'])->name('admin.bookings.update-status');
    Route::get('/admin/bookings/{id}/detail', [DashboardbokingController::class, 'DetailBooking'])->name('admin.bookings.detail');
    // customer dashboard
    Route::get('customer/dashboard', [CustomerdashboardController::class, 'index'])->name('admin.customer.dashboard');
    // ruang materi
    Route::get('/ruang-materi', [MateriAdminController::class, 'index'])->name('admin.ruang-materi.index');
    Route::get('/ruang-materi/create', [MateriAdminController::class, 'create'])->name('admin.ruang-materi.create');
    Route::post('/ruang-materi', [MateriAdminController::class, 'store'])->name('admin.ruang-materi.store');
    Route::get('/ruang-materi/{id}/edit', [MateriAdminController::class, 'edit'])->name('admin.ruang-materi.edit');
    Route::put('/ruang-materi/{id}', [MateriAdminController::class, 'update'])->name('admin.ruang-materi.update');
    Route::delete('/ruang-materi/{id}', [MateriAdminController::class, 'destroy'])->name('admin.ruang-materi.destroy');
    // submateri
    Route::get('/ruang-materi/{materi_id}/sub-materi', [SubMateriAdminController::class, 'index'])
        ->name('admin.submateri.index');
    Route::get('/ruang-materi/{materi_id}/sub-materi/create', [SubMateriAdminController::class, 'create'])
        ->name('admin.submateri.create');
    Route::post('/ruang-materi/{materi_id}/sub-materi', [SubMateriAdminController::class, 'store'])
        ->name('admin.submateri.store');
    Route::get('/ruang-materi/{materi_id}/sub-materi/{id}/edit', [SubMateriAdminController::class, 'edit'])
        ->name('admin.submateri.edit');
    Route::put('/ruang-materi/{materi_id}/sub-materi/{id}', [SubMateriAdminController::class, 'update'])
        ->name('admin.submateri.update');
    Route::delete('/ruang-materi/{materi_id}/sub-materi/{id}', [SubMateriAdminController::class, 'destroy'])
        ->name('admin.submateri.destroy');
});
Route::prefix('customer')->middleware(['auth', 'role:CUSTOMER'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('customer.home.index');
    Route::get('catalog', [CatalogController::class, 'index'])->name('customer.catalog.index');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('customer.booking.show');
    Route::post('/booking/{product}', [BookingController::class, 'store'])->name('customer.booking.store');
    Route::get('/my-archives', [BookingController::class, 'index'])->name('customer.rental.index');
    Route::get('/rental/detail/{id}', [BookingController::class, 'showBooking'])->name('customer.user.rental.detail');
    Route::post('/rental/payment/{id}', [BookingController::class, 'submitPayment'])->name('customer.payment.submit');
    // profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('customer.profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('customer.profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('customer.profil.update');
    // ruang belajar
    Route::get('/ruang-belajar', [MatapelajaranController::class, 'index'])->name('customer.materi.index');
    Route::get('/ruang-belajar/{id}', [MatapelajaranController::class, 'show'])->name('customer.materi.show');
    Route::get('/ruang-belajar/{materi_id}/bab/{id}', [MatapelajaranController::class, 'belajar'])->name('customer.materi.belajar');
});



route::get('/Matapelajaran', function () {
    return view('frontend.user.pembelajaran.matapelajaran');
});