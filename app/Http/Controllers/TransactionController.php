<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Services\MidtransService;

// class TransactionController extends Controller
// {
//     protected $midtrans;

//     public function __construct(MidtransService $midtransService)
//     {
//         $this->midtrans = $midtransService;
//     }

//    public function createTransaction(Request $request)
//     {
//         // Validasi input jika diperlukan
//         $request->validate([
//             'nama_penyewa' => 'required|string',
//             'barang_id' => 'required|exists:barangs,id',
//             'jumlah_sewa' => 'required|integer',
//             'durasi_sewa' => 'required|integer',
//             'total_harga' => 'required|integer',
//         ]);

//         // Generate order ID
//         $orderId = 'INV-' . rand(100000, 999999);

//         // Simpan ke tabel transaksis
//         $transaksi = Transaksi::create([
//             'nama_penyewa' => $request->nama_penyewa,
//             'barang_id' => $request->barang_id,
//             'jumlah_sewa' => $request->jumlah_sewa,
//             'durasi_sewa' => $request->durasi_sewa,
//             'total_harga' => $request->total_harga,
//             'status' => 'pending',
//             'order_id' => $orderId, // tambahkan kolom order_id di tabel transaksis
//         ]);

//         // Detail transaksi untuk Midtrans
//         $transactionDetails = [
//             'transaction_details' => [
//                 'order_id' => $orderId,
//                 'gross_amount' => $transaksi->total_harga,
//             ],
//             'customer_details' => [
//                 'first_name' => $request->nama_penyewa,
//                 // tambahkan field lain seperti email, phone, dll
//             ],
//         ];

//         $snapToken = $this->midtrans->getSnapToken($transactionDetails);

//         return view('transaction', compact('snapToken', 'transaksi'));
//     }
// }