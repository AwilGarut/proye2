<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Services\MidtransService;

class TransaksiController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtrans = $midtransService;
    }

    public function index()
    {
        $transaksis = Transaksi::all();
        return view('user.transaksi.index', compact('transaksis'));
    }

    public function create($id)
    {
        $barang = Barang::findOrFail($id);
        return view('user.transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_sewa' => 'required|numeric|min:1',
            'durasi_sewa' => 'required|numeric|min:1',
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
                // tambah email, phone jika diperlukan
            ],
        ];

        $snapToken = $this->midtrans->getSnapToken($transactionDetails);

        return view('user.transaksi.transaction', compact('snapToken', 'transaksi'));
    }

    public function success()
    {
        return view('transaksi.user');
    }
}
