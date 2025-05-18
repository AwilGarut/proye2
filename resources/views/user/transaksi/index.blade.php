<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        .status-pending { color: #ffcc00; }
        .status-success { color: #28a745; }
        .status-failed { color: #dc3545; }
        .status-canceled { color: #6c757d; }

        /* Dropdown Status */
        .form-select {
            min-width: 150px;
        }

        /* Footer */
        footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Daftar Pesanan</h1>

        @if ($transaksis->isEmpty())
            <p>Tidak ada pesanan ditemukan.</p>
        @else
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Sewa</th>
                        <th>Durasi Sewa</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Dibuat pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaksi->nama_barang }}</td>
                            <td>{{ $transaksi->jumlah_sewa }}</td>
                            <td>{{ $transaksi->durasi_sewa }} hari</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('transaksi.updateStatus', $transaksi->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>belum bayar</option>
                                        <option value="success" {{ $transaksi->status == 'success' ? 'selected' : '' }}>selesai</option>
                                        
                                    </select>
                                </form>
                            </td>
                            <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Footer -->
        <footer class="mt-5 text-center">
            <small>&copy; 2025 Your Company</small>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>