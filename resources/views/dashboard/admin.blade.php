<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2f3640;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logout {
            float: right;
            color: white;
            text-decoration: none;
        }

        h1 {
            margin-top: 0;
        }

        .menu {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .menu a {
            text-decoration: none;
            background-color: #40739e;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .menu a:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Dashboard Admin
        <a href="{{ route('logout') }}" class="logout">Logout</a>
    </div>
    
    <div class="container">
        <h1>Selamat datang Admin {{ auth()->user()->name }}</h1>

        <div class="menu">
            <a href="#">Manajemen Pengguna</a>
            <a href="#">Kelola Produk</a>
            <a href="#">Laporan Transaksi</a>
        </div>

        <div class="card">
            <h2>Statistik Hari Ini</h2>
            <p>Total User Terdaftar: 120</p>
            <p>Total Transaksi: 45</p>
            <p>Pendapatan Hari Ini: Rp 1.500.000</p>
        </div>
    </div>
</body>
</html>
