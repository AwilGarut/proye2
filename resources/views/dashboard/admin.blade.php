@extends('layouts.app')

<body class="bg-light">
    <div class="container py-4">
        
        {{-- <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form> --}}


        <h1>Admin Page</h1>

        <!-- Tombol Tambah Barang -->
        <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

        <!-- Tombol Lihat Daftar Pengguna -->
        <a href="{{ route('users.index') }}" class="btn btn-info mb-3 text-white">Lihat Daftar Pengguna</a>

        {{-- Konten dinamis --}}
        @yield('content')
    </div>

    <!-- JS Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>