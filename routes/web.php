<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
// use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampingInfoController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])
     ->middleware('auth') // Optional, bisa disesuaikan
     ->name('admin.users.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin' 
            ? view('dashboard.admin') 
            : view('dashboard.user');
    })->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    });
});

Route::get('/', function() {
    return view('auth.beranda');
});

// Form tambah barang
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');

// Simpan barang
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');

// Menampilkan daftar barang
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

// Menampilkan form edit
Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');

// Update data barang
Route::put('/barang/{id}/update', [BarangController::class, 'update'])->name('barang.update');

// Hapus data barang
Route::delete('/barang/{id}/delete', [BarangController::class, 'destroy'])->name('barang.delete');

Route::get('/produk', [BarangController::class, 'showAll'])->name('barang.user');
Route::get('/user', [BarangController::class, 'showAll'])->name('barang.user');

// Halaman form transaksi
Route::get('/transaksi/{id}', [TransaksiController::class, 'create'])->name('transaksi.create');

// Proses simpan transaksi
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/user', [TransaksiController::class, 'success'])
    ->name('transaksi.user');
Route::patch('/transaksi/{id}/update-status', [TransaksiController::class, 'updateStatus'])
    ->name('transaksi.updateStatus');
    
Route::get('/transaksi/index', [TransaksiController::class, 'index'])->name('transaksi.index');

// Halaman admin (tanpa middleware)
// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::resource('orders', OrderController::class);
// });

Route::get('/pesanan', [TransaksiController::class, 'index'])->name('admin.orders.update');


// Route::post('/payment-notification', [TransactionController::class, 'handlePaymentNotification']);
// Untuk menerima notifikasi pembayaran dari Midtrans

Route::get('/transaction', [TransactionController::class, 'createTransaction']);
Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback']);

Route::get('/laporan', [TransactionController::class, 'laporanIndex'])->name('laporan.index');
Route::get('/laporan/{transaksi}', [TransactionController::class, 'laporanShow'])->name('laporan.show');
Route::get('/bantuan', [CampingInfoController::class, 'index'])->name('camping.info');