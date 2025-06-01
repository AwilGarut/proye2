<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px; /* Adjusted for better readability on larger screens */
            margin: 50px auto; /* Centering the container */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px; /* Added margin for spacing */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px; /* Adjusted padding */
            text-align: left; /* Align text to left for better readability, center for specific columns if needed */
            border-bottom: 1px solid #dee2e6; /* Lighter border */
        }

        th {
            background-color: #e9ecef; /* Light grey background for headers */
            color: #495057;
            text-align: center; /* Center align table headers */
        }

        td {
            text-align: center; /* Center align table data cells */
        }

        /* Footer */
        footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
        }

        /* Ensure table is responsive */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Daftar Pesanan</h1>

        @if ($transaksis->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                Tidak ada pesanan ditemukan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penyewa</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Sewa</th>
                            <th>Durasi Sewa</th>
                            <th>Dibuat pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaksi->nama_penyewa }}</td>
                                <td>{{ $transaksi->nama_barang }}</td>
                                <td>{{ $transaksi->jumlah_sewa }}</td>
                                <td>{{ $transaksi->durasi_sewa }} hari</td>
                                <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <footer class="mt-5 text-center">
            <small>&copy; {{ date('Y') }} Your Company</small> </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>