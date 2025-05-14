@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Barang Tersedia</h2>

    <div class="row">
        @forelse ($barangs as $barang)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=Tidak+Ada+Gambar " class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                        <p class="card-text">Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                        <p class="card-text">Stok: {{ $barang->stok }}</p>
                        <a href="{{ route('transaksi.create', $barang->id) }}" class="btn btn-primary">Sewa Sekarang</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada barang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection