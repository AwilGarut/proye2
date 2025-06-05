<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Pembayaran</h2>

        <button id="pay-button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
            Bayar Sekarang
        </button>

        <p class="text-sm text-gray-500 mt-4">Klik tombol di atas untuk melanjutkan ke proses pembayaran.</p>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log("Pembayaran Sukses", result);

                    fetch('/payment/success', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            transaction_id: result.order_id,
                            status: 'success',
                            result: result,
                            // Tambahkan data lain sesuai kebutuhan
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data.status === 'success') {
                            alert('Pembayaran berhasil!');
                            window.location.href = '/produk';
                        } else {
                            alert('Gagal menyimpan data: ' + (data.message || 'Terjadi kesalahan'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan saat mengirim data ke server.');
                    });
                },

                onPending: function(result) {
                    console.log("Menunggu Pembayaran", result);
                    alert("Transaksi dalam status pending.");
                },

                onError: function(result) {
                    console.log("Terjadi kesalahan", result);
                    alert("Gagal melakukan pembayaran.");
                }
            });
        };
    </script>

</body>
</html>