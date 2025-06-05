<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <title>Laporan Transaksi</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Jika Anda perlu CSS tambahan khusus untuk halaman ini --}}
    {{-- Contoh: <link rel="stylesheet" href="{{ asset('css/laporan.css') }}"> --}}
    {{-- Jika Anda menggunakan DataTables via CDN atau lokal --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> --}}

    <style>
        /* Anda bisa menambahkan CSS kustom di sini jika perlu */
        body {
            background-color: #f8f9fa; /* Warna latar belakang dasar */
             background-image: url('../images/ngopi.jpeg'); 
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3">Laporan Transaksi</h1>
            <p>Berikut adalah daftar semua transaksi yang telah tercatat.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
<a href="{{ route('dashboard') }}" class="btn btn-primary">dashboard</a>
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            {{-- Menggunakan <th> untuk header tabel adalah praktik terbaik --}}
                            <th>No</th>
                            <th>Nama Penyewa</th>
                            <th>Nama Barang</th>
                            <th>Jml</th>
                            <th>Durasi (hari)</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $transaksis->firstItem() + $index }}</td>
                            <td>{{ $transaksi->nama_penyewa }}</td>
                            <td>{{ $transaksi->nama_barang }}</td>
                            <td>{{ $transaksi->jumlah_sewa }}</td>
                            <td>{{ $transaksi->durasi_sewa }}</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if (in_array(strtolower($transaksi->status), ['success', 'settlement', 'capture']))
                                    <span class="badge badge-success">{{ ucfirst($transaksi->status) }}</span>
                                @elseif (strtolower($transaksi->status) == 'pending')
                                    <span class="badge badge-warning">{{ ucfirst($transaksi->status) }}</span>
                                @elseif (in_array(strtolower($transaksi->status), ['expired', 'failure']))
                                    <span class="badge badge-secondary">{{ ucfirst($transaksi->status) }}</span>
                                @elseif (in_array(strtolower($transaksi->status), ['cancelled', 'denied']))
                                    <span class="badge badge-danger">{{ ucfirst($transaksi->status) }}</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst($transaksi->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $transaksi->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transaksis->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $transaksis->links() }} {{-- Untuk navigasi pagination --}}
            </div>
            @endif
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js" integrity="sha384-q9CRHqZndzlxGLOj+xrdLDJa9ittGte1N2rP9H3L9R4wSCmJiiMhG//ZfQ3KjR3g" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    {{-- Jika Anda perlu JS tambahan khusus untuk halaman ini --}}
    {{-- Contoh: <script src="{{ asset('js/laporan.js') }}"></script> --}}
    {{-- Jika Anda menggunakan DataTables via CDN atau lokal --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script>
        $(document).ready(function() {
            // Inisialisasi DataTables jika Anda tidak menggunakan pagination Laravel dan ingin fitur DataTables
            // $('.table').DataTable();
        });
    </script> --}}

</body>
</html>