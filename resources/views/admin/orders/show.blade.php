@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pesanan</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Nama Barang</th>
                <th>Jumlah Sewa</th>
                <th>Durasi Sewa</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Dibuat pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->name ?? 'Tidak ditemukan' }}</td>
                <td>{{ $order->campProduct->name ?? 'Tidak ditemukan' }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->duration }} hari</td>
                <td>Rp {{ number_format($order->total_price) }}</td>
                <td>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Update Status</button>
                    </form>
                </td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection