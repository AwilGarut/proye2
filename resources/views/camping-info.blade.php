@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyewaan Alat Camping</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS Internal -->
    
</head>
<body>

    <div class="container py-5">
        <h1>🏕️ Penyewaan Alat Camping</h1>

        <section class="mb-4">
            <h2>Paket Sewa Tersedia</h2>
            <ul>
                <li>Paket Hemat Solo (1 orang)</li>
                <li>Paket Pasangan (2 orang)</li>
                <li>Paket Keluarga/Teman (4–6 orang)</li>
                <li>Sewa Satuan (jika hanya butuh beberapa alat)</li>
            </ul>
        </section>

        <section class="mb-4">
            <h2>Lokasi Layanan</h2>
            <li>melayani penyewaan di wilayah sekitar Indramayu</li> 
        </section>

        <section class="mb-4">
            <h2>Durasi Sewa</h2>
            <ul>
                <li>Minimal sewa 1 hari</li>
                <li>Bisa disesuaikan dengan durasi pendakian/kemah</li>
                <li>Denda akan dikenakan jika keterlambatan mengembalikan</li>
            </ul>
        </section>

        <section class="mb-4">
            <h2>Hubungi Kami</h2>
            <ul>
                <li><i class="fab fa-whatsapp"></i> WhatsApp: <a href="https://wa.me/+6285720770009 ">paderngopi</a></li>
                <li><i class="fab fa-instagram"></i> Instagram: <a href="https://instagram.com/penyewaan_camping_id ">@paderngopiadventure</a></li>
                <li><i class="fab fa-facebook-f"></i> Facebook: <a href="https://facebook.com/PenyewaanCampingID ">Paderngopiadventure</a></li>
                <li><i class="fas fa-envelope"></i> Email: <a href="mailto:campingsewa@email.com">paderngopiadventur@email.com</a></li>
            </ul>
        </section>

        <section class="mb-4">
            <h2>Tips Saat Menyewa Alat Camping</h2>
            <ul>
                <li>Pastikan alat dalam kondisi baik saat diterima.</li>
                <li>Cek kelengkapan sesuai invoice/persetujuan awal.</li>
                <li>Jaga alat seperti milik sendiri agar tidak kena denda.</li>
            </ul>
        </section>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js " crossorigin="anonymous"></script>
</body>
</html>
@endsection