<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])
     ->middleware('auth') // Optional, bisa disesuaikan
     ->name('admin.users.index');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin' 
            ? view('dashboard.admin') 
            : view('dashboard.user');
    })->name('dashboard');
});


Route::get('/', function() {
    return view('auth.beranda');
});
