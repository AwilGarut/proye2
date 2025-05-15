<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pader Ngopi Adventure</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">☕ Pader Ngopi Adventure</div>
    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="{{ route('barang.user') }}">Produk</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </li>
    </ul>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="overlay"></div>
    <div class="content">
        <h1>Selamat Datang Pader Ngopi Adventure</h1>
        <p>Selamat datang di Pader Ngopi Adventure. Temukan dan sewa perlengkapan camping terbaik untuk petualangan seru Anda.</p>
        <div class="buttons">
            <a href="{{ route('barang.user') }}" class="btn btn-primary">Lihat Produk</a>
            <a href="#" class="btn btn-secondary">Tentang Kami</a>
        </div>
    </div>
</section>

<!-- Produk Section -->       
</section>

<footer class="footer">
    <p>&copy; 2025 Pader Ngopi Adventure. All rights reserved.</p>
</footer>

</body>
</html>