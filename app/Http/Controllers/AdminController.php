<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua data user
        return view('dashboard.manajemen_pengguna', compact('users')); // Kirim ke view
    }
}
