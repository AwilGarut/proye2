<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log; 

class TransactionController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtrans = $midtransService;
    }

    // Untuk halaman laporan transaksi admin
    public function laporanIndex()
    {
        $transaksis = Transaksi::orderBy('created_at', 'desc')->paginate(15);
        return view('laporan.index', compact('transaksis'));
    }

    // Membuat transaksi baru dan mendapatkan Snap Token Midtrans
    public function createTransaction(Request $request)
    {
        $request->validate([
            'nama_penyewa' => 'required|string',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_sewa' => 'required|integer',
            'durasi_sewa' => 'required|integer',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $total_harga = $barang->harga * $request->jumlah_sewa * $request->durasi_sewa;
        $orderId = 'INV-' . rand(100000, 999999);

        $transaksi = Transaksi::create([
            'nama_penyewa' => $request->nama_penyewa,
            'nama_barang' => $barang->nama_barang,
            'barang_id' => $request->barang_id,
            'jumlah_sewa' => $request->jumlah_sewa,
            'durasi_sewa' => $request->durasi_sewa,
            'total_harga' => $total_harga,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->nama_penyewa,
            ],
        ];

        $snapToken = $this->midtrans->getSnapToken($transactionDetails);

        return view('user.transaksi.transaction', compact('snapToken', 'transaksi'));
    }

    // Callback dari Midtrans setelah pembayaran
    public function handleCallback(Request $request)
{
    $payload = $request->all();
    Log::info('Midtrans callback received', $payload); // log data

    $orderId = $payload['order_id'] ?? null;
    $transactionStatus = $payload['transaction_status'] ?? null;

    $transaksi = Transaksi::where('order_id', $orderId)->first();

    if (!$transaksi) {
        Log::warning("Transaksi tidak ditemukan untuk order_id: $orderId");
        return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
    }

    if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
        $transaksi->status = 'paid';
        $transaksi->save();

        $barang = Barang::find($transaksi->barang_id);
        if ($barang) {
            $barang->stok -= $transaksi->jumlah_sewa;
            $barang->save();

            Log::info("Stok barang {$barang->nama_barang} dikurangi: {$transaksi->jumlah_sewa}");
        }
    } elseif ($transactionStatus === 'expire' || $transactionStatus === 'cancel') {
        $transaksi->status = 'failed';
        $transaksi->save();
    }

    return response()->json(['message' => 'Callback diproses']);
}
}
