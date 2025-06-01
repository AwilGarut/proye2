<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js " data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h2>Bayar Sekarang</h2>

    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    console.log("Pembayaran Sukses", result);
                    window.location.href = 'produk';
                },
                onPending: function(result){
                    console.log("Menunggu Pembayaran", result);
                    window.location.href = '/transaksi/pending';
                },
                onError: function(result){
                    console.log("Error", result);
                    window.location.href = '/transaksi/gagal';
                }
            });
        };
    </script>
</body>
</html>