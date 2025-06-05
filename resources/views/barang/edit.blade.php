@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Spoofing method untuk PUT -->

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang', $barang->nama_barang) }}">
            @error('nama_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $barang->harga) }}">
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $barang->stok) }}">
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>Gambar Saat Ini</label><br>
            @if ($barang->gambar)
                <img src="{{ asset('storage/'.$barang->gambar) }}" alt="Gambar" width="100"><br>
            @else
                <span class="text-muted">Tidak ada gambar</span>
            @endif
        </div>

        <div class="form-group mt-3">
            <label>Upload Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection