<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Pader Ngopi Adventure</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #5c4c45;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-left, .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .hero {
            background-image: url('https://via.placeholder.com/1200x400'); /* Ganti dengan URL gambar gunung */
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
        }
        .info {
            background-color: #c1a49b;
            color: white;
            text-align: center;
            padding: 15px;
            font-weight: bold;
        }
        .button-container {
            text-align: center;
            margin: 20px;
        }
        .button-container button {
            padding: 10px 30px;
            background-color: #5c4c45;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cards {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            padding: 30px;
            background-color: #d2bdb5;
        }
        .card {
            width: 180px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
        }
        .card img {
            width: 100%;
            border-radius: 5px;
        }
        .card .price {
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-left">
            <a href="#">Pader Ngopi Adventure</a>
            <a href="#">BERANDA</a>
            <a href="#">SEWA</a>
            <a href="#">BANTUAN</a>
            <a href="#">HUBUNGI KAMI</a>
        </div>
        <div class="navbar-right">
            <a href="#"><img src="https://img.icons8.com/material-rounded/24/ffffff/shopping-cart.png"/></a>
            <a href="#">Queen ▼</a>
        </div>
    </div>

    <div class="hero">
        PADER NGOPI ADVENTURE
    </div>

    <div class="info">
        KLIK PADA GAMBAR UNTUK BOOKING SECARA ONLINE
    </div>

    <div class="button-container">
        <button>SEWA TENDA</button>
    </div>

    <div class="cards">
        @for ($i = 1; $i <= 5; $i++)
        <div class="card">
            <img src="https://via.placeholder.com/150" alt="Produk {{ $i }}">
            <div>Text</div>
            <div class="price">$0</div>
        </div>
        @endfor
    </div>

</body>
</html>