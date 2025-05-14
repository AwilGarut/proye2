<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user || !$user->is_admin) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        $orders = Order::with(['user', 'campProduct'])->get();
        return view('admin.orders.index', compact('orders'));
    }
}