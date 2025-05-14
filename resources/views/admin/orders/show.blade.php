@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Detail Pesanan #{{ $order->id }}
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Pengguna</h5>
                    <p>{{ $order->user->name }}<br>{{ $order->user->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Alamat Pengiriman</h5>
                    <p>{{ $order->address }}</p>
                </div>
            </div>

            <h5>Produk</h5>
            <p>{{ $order->campProduct->name }}</p>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Status Pesanan</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection