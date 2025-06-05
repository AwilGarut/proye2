@extends('layouts.app')

@section('content')
<a href="{{ route('barang.user') }}" class="btn btn-primary">
        <i class="bi bi-box-seam"></i> Lihat Semua Produk
    </a>
<div class="container">
    <h3>Sewa {{ $barang->nama_barang }}</h3>
     
    <div class="card mb-4">
        <div class="card-body">
            <h5>{{ $barang->nama_barang }}</h5>
            <p>Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }} / hari</p>
            <p>Stok tersedia: {{ $barang->stok }}</p>
        </div>
    </div>
    
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
        <div class="form-group">
            <label for="nama_penyewa">Nama Penyewa</label>
            <input type="text" name="nama_penyewa" id="nama_penyewa" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah yang Disewa</label>
            <input type="number" name="jumlah_sewa" class="form-control" min="1" max="{{ $barang->stok }}" required>
        </div>

        <div class="form-group mt-3">
            <label>Durasi Sewa (hari)</label>
            <input type="number" name="durasi_sewa" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Sewa Sekarang</button>
        <a href="{{ route('barang.user') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection