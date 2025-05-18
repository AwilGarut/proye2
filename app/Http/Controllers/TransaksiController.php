<?php

// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::all(); // Ambil semua data transaksi
        return view('user.transaksi.index', compact('transaksis'));
    }
    // Tampilkan form transaksi
    public function create($id)
    {
        $barang = Barang::findOrFail($id);
        return view('user.transaksi.create', compact('barang'));
    }

    // Simpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_sewa' => 'required|numeric|min:1',
            'durasi_sewa' => 'required|numeric|min:1',
        ]);

        // Hitung total harga
        $barang = Barang::find($request->barang_id);
        $total_harga = $barang->harga * $request->jumlah_sewa * $request->durasi_sewa;

        // Simpan ke database
        Transaksi::create([
            'nama_penyewa' => $request->nama_penyewa,
            'nama_barang' => $barang->nama_barang,
            'barang_id' => $request->barang_id,
            'jumlah_sewa' => $request->jumlah_sewa,
            'durasi_sewa' => $request->durasi_sewa,
            'total_harga' => $total_harga,
            'status' => 'pending', // atau sesuai logika aplikasi
        ]);

        return redirect()->route('transaksi.success')->with('success', 'Transaksi berhasil!');
    }
    public function success()
{
    return view('transaksi.success'); // atau response lainnya
}
 
}
