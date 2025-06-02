<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Services\MidtransService; // Pastikan namespace ini benar
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // Untuk validasi payload jika diperlukan

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
        $validator = Validator::make($request->all(), [
            'nama_penyewa' => 'required|string|max:255',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_sewa' => 'required|integer|min:1',
            'durasi_sewa' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan error dan input lama
            // Ini lebih cocok untuk web-based form submission daripada API
            // Jika ini adalah API endpoint, Anda mungkin ingin return response JSON
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $barang = Barang::findOrFail($request->barang_id);

        // Cek apakah stok mencukupi sebelum membuat transaksi
        if ($barang->stok < $request->jumlah_sewa) {
            // Jika ini adalah form web, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi untuk jumlah yang diminta. Stok tersedia: ' . $barang->stok)->withInput();
            // Jika ini API, return JSON error
            // return response()->json(['message' => 'Stok barang tidak mencukupi. Stok tersedia: ' . $barang->stok], 400);
        }

        $total_harga = $barang->harga * $request->jumlah_sewa * $request->durasi_sewa;
        $orderId = 'INV-' . time() . '-' . rand(1000, 9999); // Membuat order_id lebih unik

        $transaksi = Transaksi::create([
            'nama_penyewa' => $request->nama_penyewa,
            'nama_barang' => $barang->nama_barang,
            'barang_id' => $request->barang_id,
            'jumlah_sewa' => $request->jumlah_sewa,
            'durasi_sewa' => $request->durasi_sewa,
            'total_harga' => $total_harga,
            'status' => 'pending', // Status awal
            'order_id' => $orderId,
        ]);

        if (!$transaksi) {
            Log::error("Gagal membuat data transaksi untuk order_id: " . $orderId, $request->all());
            // Jika ini form web
            return redirect()->back()->with('error', 'Gagal memproses transaksi. Silakan coba lagi.')->withInput();
            // Jika API
            // return response()->json(['message' => 'Gagal memproses transaksi internal.'], 500);
        }

        Log::info("Transaksi berhasil dibuat dengan order_id: {$orderId}, barang_id: {$transaksi->barang_id}, jumlah_sewa: {$transaksi->jumlah_sewa}");

        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total_harga,
            ],
            'item_details' => [ // Menambahkan item_details untuk kejelasan di Midtrans
                [
                    'id' => $barang->id,
                    'price' => $barang->harga,
                    'quantity' => $request->jumlah_sewa * $request->durasi_sewa, // Atau sesuaikan quantity berdasarkan logika bisnis Anda
                    'name' => $barang->nama_barang,
                ]
            ],
            'customer_details' => [
                'first_name' => $request->nama_penyewa,
                // 'email' => $request->email_penyewa, // Sebaiknya ada email
                // 'phone' => $request->nomor_telepon_penyewa, // Sebaiknya ada nomor telepon
            ],
        ];

        try {
            $snapToken = $this->midtrans->getSnapToken($transactionDetails);
            // Jika Anda ingin menyimpan snap_token ke database (opsional)
            // $transaksi->snap_token = $snapToken;
            // $transaksi->save();
            return view('user.transaksi.transaction', compact('snapToken', 'transaksi'));
        } catch (\Exception $e) {
            Log::error("Midtrans Snap Token Exception untuk order_id: {$orderId}: " . $e->getMessage());
            // Jika ini form web
            return redirect()->back()->with('error', 'Gagal mendapatkan token pembayaran. Silakan coba lagi.')->withInput();
            // Jika API
            // return response()->json(['message' => 'Gagal mendapatkan token pembayaran.'], 500);
        }
    }

    // Callback dari Midtrans setelah pembayaran
    public function handleCallback(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans callback received', $payload);

        // Verifikasi signature key (SANGAT PENTING untuk keamanan)
        // Anda perlu mengimplementasikan logika verifikasi ini berdasarkan dokumentasi Midtrans
        // $isValidSignature = $this->midtrans->isValidSignature($payload, env('MIDTRANS_SERVER_KEY')); // Asumsi Anda punya method ini di MidtransService
        // if (!$isValidSignature) {
        //     Log::error('Invalid signature key from Midtrans callback.', $payload);
        //     return response()->json(['message' => 'Invalid signature'], 403); // Forbidden
        // }
        // Log::info('Midtrans signature key VERIFIED.');


        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            Log::error('Order ID tidak ditemukan di payload callback Midtrans.', $payload);
            return response()->json(['message' => 'Order ID tidak ditemukan'], 400); // Bad Request
        }

        $transaksi = Transaksi::where('order_id', $orderId)->first();

        if (!$transaksi) {
            Log::warning("Transaksi tidak ditemukan untuk order_id: $orderId. Callback diabaikan.");
            // Penting untuk tetap return 200 OK agar Midtrans tidak mengirim ulang notifikasi
            return response()->json(['message' => 'Transaksi tidak ditemukan, notifikasi diterima.'], 200);
        }

        Log::info("Transaksi ditemukan untuk order_id: $orderId. Data transaksi:", $transaksi->toArray());

        // Hindari memproses callback yang sama berulang kali jika status sudah final
        if (in_array($transaksi->status, ['paid', 'failed', 'cancelled', 'expired'])) {
            Log::info("Transaksi order_id: $orderId sudah dalam status final '{$transaksi->status}'. Callback diabaikan.");
            return response()->json(['message' => 'Transaksi sudah diproses sebelumnya.'], 200);
        }

        $updateData = [];

        if ($transactionStatus == 'capture') {
            // Untuk tipe pembayaran kartu kredit dengan capture=true
            if ($fraudStatus == 'accept') {
                // Transaksi dianggap berhasil
                $updateData['status'] = 'paid';
                Log::info("Pembayaran CAPTURE diterima (fraud accept) untuk order_id: $orderId.");
            } else if ($fraudStatus == 'challenge') {
                // Transaksi perlu direview manual
                $updateData['status'] = 'challenge'; // Atau status lain yang sesuai
                Log::warning("Pembayaran CAPTURE butuh CHALLENGE (fraud review) untuk order_id: $orderId.");
            } else {
                // Fraud ditolak
                $updateData['status'] = 'failed';
                Log::error("Pembayaran CAPTURE DITOLAK (fraud) untuk order_id: $orderId.");
            }
        } elseif ($transactionStatus == 'settlement') {
            // Transaksi berhasil dan dana sudah masuk
            $updateData['status'] = 'paid';
            Log::info("Pembayaran SETTLEMENT diterima untuk order_id: $orderId.");
        } elseif ($transactionStatus == 'pending') {
            // Transaksi masih menunggu pembayaran
            $updateData['status'] = 'pending';
            Log::info("Pembayaran PENDING untuk order_id: $orderId.");
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            // Transaksi gagal, dibatalkan, atau kadaluarsa
            if ($transactionStatus == 'deny') {
                $updateData['status'] = 'failed'; // Atau 'denied'
                Log::warning("Pembayaran DENY untuk order_id: $orderId.");
            } elseif ($transactionStatus == 'cancel') {
                $updateData['status'] = 'cancelled'; // Atau 'failed'
                Log::warning("Pembayaran CANCELLED untuk order_id: $orderId.");
            } elseif ($transactionStatus == 'expire') {
                $updateData['status'] = 'expired'; // Atau 'failed'
                Log::warning("Pembayaran EXPIRED untuk order_id: $orderId.");
            }
        } else {
            Log::info("Status transaksi tidak dikenal atau tidak memerlukan aksi khusus: '$transactionStatus' untuk order_id: $orderId");
            // Tetap return 200 OK agar Midtrans tidak retry jika ini status yang tidak Anda handle
            return response()->json(['message' => 'Status transaksi tidak memerlukan aksi'], 200);
        }

        // Simpan perubahan status transaksi
        if (!empty($updateData)) {
            $transaksi->fill($updateData);
            if (!$transaksi->save()) {
                Log::error("Gagal menyimpan status '{$updateData['status']}' untuk transaksi order_id: $orderId");
                // Jika gagal simpan, ini masalah serius, mungkin return 500 agar Midtrans retry
                return response()->json(['message' => 'Gagal memproses pembayaran, error server internal'], 500);
            }
            Log::info("Status transaksi order_id: $orderId berhasil diubah menjadi '{$transaksi->status}'.");
        }


        // Proses pengurangan stok HANYA jika status menjadi 'paid'
        if ($transaksi->status === 'paid') {
            Log::info("Memulai proses pengurangan stok untuk order_id: $orderId karena status 'paid'.");

            // Pastikan barang_id ada dan bukan null
            if (is_null($transaksi->barang_id)) {
                Log::error("barang_id pada transaksi order_id: $orderId adalah NULL. Stok tidak dapat dikurangi.");
                // Anda mungkin ingin mengirim notifikasi ke admin di sini
            } else {
                $barang = Barang::find($transaksi->barang_id);
                if ($barang) {
                    Log::info("Barang ditemukan: {$barang->nama_barang} (ID: {$barang->id}). Stok saat ini: {$barang->stok}. Jumlah sewa: {$transaksi->jumlah_sewa}");

                    // Pastikan jumlah_sewa adalah numerik dan lebih besar dari 0
                    if (!is_numeric($transaksi->jumlah_sewa) || $transaksi->jumlah_sewa <= 0) {
                        Log::warning("Jumlah sewa tidak valid ({$transaksi->jumlah_sewa}) untuk transaksi order_id: $orderId. Stok tidak diubah.");
                    } else {
                        // Cek apakah stok masih mencukupi (double check, karena bisa ada race condition)
                        if ($barang->stok < $transaksi->jumlah_sewa) {
                            Log::error("Stok barang {$barang->nama_barang} (ID: {$barang->id}) tidak mencukupi ({$barang->stok}) untuk dikurangi {$transaksi->jumlah_sewa} pada transaksi order_id: $orderId. Stok tidak diubah.");
                            // Kirim notifikasi ke admin tentang masalah stok ini
                            // Mungkin Anda perlu membatalkan transaksi ini atau menandainya untuk review manual
                        } else {
                            $barang->stok -= $transaksi->jumlah_sewa;
                            if ($barang->save()) {
                                Log::info("Stok barang {$barang->nama_barang} (ID: {$barang->id}) berhasil dikurangi sebanyak: {$transaksi->jumlah_sewa}. Stok baru: {$barang->stok} untuk order_id: $orderId.");
                            } else {
                                Log::error("Gagal menyimpan perubahan stok untuk barang ID: {$barang->id} pada transaksi order_id: $orderId.");
                                // Ini juga masalah serius, mungkin perlu notifikasi admin
                            }
                        }
                    }
                } else {
                    Log::warning("Barang dengan ID: {$transaksi->barang_id} tidak ditemukan untuk transaksi order_id: $orderId. Stok tidak dikurangi.");
                    // Kirim notifikasi ke admin bahwa ada transaksi untuk barang yang tidak ada
                }
            }
        } elseif (in_array($transaksi->status, ['cancelled', 'expired', 'failed'])) {
            // Jika transaksi gagal/dibatalkan/kadaluarsa SETELAH stok pernah dikurangi (logika ini belum ada, tapi sebagai contoh)
            // Maka Anda mungkin perlu menambahkan logika untuk mengembalikan stok.
            // Untuk kasus ini, karena stok baru dikurangi saat 'paid', maka tidak perlu pengembalian stok jika dari awal sudah gagal.
            Log::info("Transaksi order_id: {$orderId} statusnya '{$transaksi->status}'. Tidak ada pengurangan stok atau stok sudah sesuai.");
        }

        // Selalu kirim response 200 OK ke Midtrans jika notifikasi sudah diterima dan diproses (atau diabaikan secara sengaja)
        return response()->json(['message' => 'Callback berhasil diproses']);
    }
}
