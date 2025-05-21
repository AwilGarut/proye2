<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Midtrans</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js " data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>
<body>
    <h2>Transaksi Pembayaran</h2>
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    console.log(result);
                },
                onPending: function(result){
                    alert("Menunggu Pembayaran!");
                    console.log(result);
                },
                onError: function(result){
                    alert("Pembayaran Gagal!");
                    console.log(result);
                }
            });
        };
    </script>
</body>
</html>