<?php
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])
     ->middleware('auth') // Optional, bisa disesuaikan
     ->name('admin.users.index');