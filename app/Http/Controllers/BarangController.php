<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        // Ambil semua data barang dari database
        $barangs = Barang::all();

        // Kirim data ke view
        return view('barang.index', compact('barangs'));
    }

    // Form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Simpan data barang
    public function store(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nama_barang' => 'required|string|max:255',
        'harga' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Upload gambar jika ada
    $gambarPath = null;
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('barang', 'public');
    }

    // Simpan ke database
    Barang::create([
        'nama_barang' => $request->input('nama_barang'),
        'harga' => $request->input('harga'),
        'stok' => $request->input('stok'),
        'gambar' => $gambarPath,
    ]);

    // Redirect ke halaman daftar barang
    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
}
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('barang', 'public');
        } else {
            $gambarPath = $barang->gambar; // Gunakan gambar lama
        }

        // Update data barang
        $barang->update([
            'nama_barang' => $request->input('nama_barang'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        // Hapus data barang
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
    // app/Http/Controllers/BarangController.php

public function showAll()
{
    $barangs = \App\Models\Barang::where('stok', '>', 0)->get(); // hanya barang yang tersedia
    return view('user.barang.index', compact('barangs'));
}
}
