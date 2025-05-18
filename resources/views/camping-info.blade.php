<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center mb-4">🏕️ {{ $title }}</h1>

        <section class="mb-4">
            <h2>📦 Paket Sewa Tersedia</h2>
            <ul>
                @foreach ($paket_sewa as $paket)
                    <li>{{ $paket }}</li>
                @endforeach
            </ul>
        </section>

        <section class="mb-4">
            <h2>📍 Lokasi Layanan</h2>
            <p>{{ $lokasi_layanan }}</p>
        </section>

        <section class="mb-4">
            <h2>📅 Durasi Sewa</h2>
            <ul>
                @foreach ($durasi_sewa as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </section>

        <section class="mb-4">
            <h2>💬 Hubungi Kami</h2>
            <ul>
                <li>📲 WhatsApp: <a href="https://wa.me/ {{ $kontak['whatsapp'] }}" target="_blank">{{ $kontak['whatsapp'] }}</a></li>
                <li>📍 Instagram: <a href="https://instagram.com/ {{ $kontak['instagram'] }}" target="_blank">{{ $kontak['instagram'] }}</a></li>
                <li>📍 Facebook: <a href="https://facebook.com/ {{ $kontak['facebook'] }}" target="_blank">{{ $kontak['facebook'] }}</a></li>
                <li>📧 Email: <a href="mailto:{{ $kontak['email'] }}">{{ $kontak['email'] }}</a></li>
            </ul>
        </section>

        <section class="mb-4">
            <h2>📝 Tips Saat Menyewa Alat Camping</h2>
            <ul>
                @foreach ($tips as $tip)
                    <li>{{ $tip }}</li>
                @endforeach
            </ul>
        </section>
    </div>

</body>
</html>