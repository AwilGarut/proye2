<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Pader Ngopi Adventure</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }
        .hero {
            background-image: url('/images/beranda-hero.jpeg'); /* Ganti dengan path gambar yang sesuai */
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* efek gelap agar teks lebih jelas */
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 18px;
        }
        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 2;
        }
        .auth-buttons a {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            margin-left: 10px;
            background-color: white;
            color: #333;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        .auth-buttons a:hover {
            background-color: #ddd;
        }
        @media (max-width: 600px) {
            .hero h1 {
                font-size: 32px;
            }
            .auth-buttons a {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="hero-overlay"></div>
        <div class="auth-buttons">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
        <div class="hero-content">
            <h1>PADER NGOPI ADVENTURE</h1>
            <p>Selamat datang di Pader Ngopi Adventure. Temukan dan sewa perlengkapan camping terbaik untuk petualangan seru Anda.</p>
        </div>
    </div>

</body>
</html>
