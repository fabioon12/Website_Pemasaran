<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\logincontroller;
use App\Http\Controllers\auth\registercontroller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardbokingController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\BookingController;
USE App\Http\Controllers\Customer\ProfilController;
use App\Http\Controllers\landingpage\CataloglandingController;
use App\Http\Controllers\CustomerdashboardController;



//Landing Page
Route::get('/', function () {
    return view('landingpage.welcome');
});
Route::get('/catalog', [CataloglandingController::class, 'index'])->name('catalog.index');
// Authentication Routes
Route::middleware(['redirectIfAuthenticated'])->group(function () {
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
});
Route::prefix('customer')->middleware(['auth', 'role:CUSTOMER'])->group(function () {
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
});



