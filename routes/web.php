<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FakturController;

// Redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman register & login
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// ADMIN ROUTES
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class);
});

// USER ROUTES
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/katalog', [UserController::class, 'katalog'])->name('katalog');
    Route::get('/tambah-keranjang/{id}', [UserController::class, 'tambahKeranjang'])->name('tambah.keranjang');
    Route::get('/keranjang', [UserController::class, 'keranjang'])->name('keranjang');
    Route::post('/checkout', [FakturController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [FakturController::class, 'invoice'])->name('invoice');
});
