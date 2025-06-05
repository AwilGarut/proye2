@extends('layouts.app') <!-- Pastikan layout sudah ada -->

@section('content')
    <div class="container">
        <h1>Daftar Barang</h1>

        <!-- Tombol Tambah Barang -->
        <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

        <!-- Tabel Daftar Barang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>
                            @if ($barang->gambar)
                                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}"
                                    width="100">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <!-- Tombol Hapus dengan Form -->
                            <form action="{{ route('barang.delete', $barang->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data barang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
