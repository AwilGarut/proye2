<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Services\MidtransService;

class TransactionController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtrans = $midtransService;
    }

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
}
