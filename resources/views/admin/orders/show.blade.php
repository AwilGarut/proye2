@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar </h2>

    {{-- Pesan Sukses (Opsional, jika Anda menggunakannya di controller) --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

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
                <th>Aksi</th> {{-- Kolom baru untuk aksi --}}
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order) {{-- Gunakan forelse untuk menangani jika $orders kosong --}}
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->name ?? 'Tidak ditemukan' }}</td>
                <td>{{ $order->campProduct->name ?? 'Tidak ditemukan' }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->duration }} hari</td>
                <td>Rp {{ number_format($order->total_price) }}</td>
                <td>
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PUT')
                        <div class="input-group input-group-sm">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            {{-- Tombol update status bisa disembunyikan jika menggunakan onchange --}}
                            {{-- <button type="submit" class="btn btn-sm btn-primary ms-1">Update</button> --}}
                        </div>
                    </form>
                </td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>
                    {{-- Tombol Edit --}}
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
{{-- Jika Anda menggunakan Font Awesome untuk ikon --}}
{{-- <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script> --}}
@endpush