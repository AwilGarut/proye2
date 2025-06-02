<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Services\MidtransService; // Pastikan namespace ini benar
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah_sewa) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi untuk jumlah yang diminta. Stok tersedia: ' . $barang->stok)->withInput();
        }

        $total_harga = $barang->harga * $request->jumlah_sewa * $request->durasi_sewa;
        $orderId = 'INV-' . time() . '-' . rand(1000, 9999);

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

        if (!$transaksi) {
            Log::error("Gagal membuat data transaksi untuk order_id: " . $orderId, $request->all());
            return redirect()->back()->with('error', 'Gagal memproses transaksi. Silakan coba lagi.')->withInput();
        }

        Log::info("Transaksi berhasil dibuat dengan order_id: {$orderId}, barang_id: {$transaksi->barang_id}, jumlah_sewa: {$transaksi->jumlah_sewa}");

        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total_harga,
            ],
            'item_details' => [
                [
                    'id' => $barang->id,
                    'price' => $barang->harga,
                    'quantity' => $request->jumlah_sewa * $request->durasi_sewa,
                    'name' => $barang->nama_barang,
                ]
            ],
            'customer_details' => [
                'first_name' => $request->nama_penyewa,
            ],
        ];

        try {
            $snapToken = $this->midtrans->getSnapToken($transactionDetails);
            return view('user.transaksi.transaction', compact('snapToken', 'transaksi'));
        } catch (\Exception $e) {
            Log::error("Midtrans Snap Token Exception untuk order_id: {$orderId}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mendapatkan token pembayaran. Silakan coba lagi.')->withInput();
        }
    }

    // Callback dari Midtrans setelah pembayaran
    public function handleCallback(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans callback received', $payload);

        // Implementasikan verifikasi signature key di sini! Ini sangat penting.
        // Jika verifikasi gagal, return response()->json(['message' => 'Invalid signature'], 403);

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            Log::error('Order ID tidak ditemukan di payload callback Midtrans.', $payload);
            return response()->json(['message' => 'Order ID tidak ditemukan'], 400);
        }

        // Gunakan try-catch dengan transaksi database
        try {
            // Mulai transaksi database
            // Penting: Pastikan tabel Anda menggunakan engine yang mendukung transaksi (InnoDB untuk MySQL)
            $result = DB::transaction(function () use ($orderId, $transactionStatus, $fraudStatus, $payload) {

                $transaksi = Transaksi::where('order_id', $orderId)->lockForUpdate()->first(); // lockForUpdate untuk mencegah race condition

                if (!$transaksi) {
                    Log::warning("Transaksi tidak ditemukan untuk order_id: $orderId. Callback diabaikan.");
                    return ['status_code' => 200, 'message' => 'Transaksi tidak ditemukan, notifikasi diterima.'];
                }

                Log::info("Transaksi ditemukan untuk order_id: $orderId. Status saat ini: {$transaksi->status}. Data transaksi:", $transaksi->toArray());

                if (in_array($transaksi->status, ['paid', 'failed', 'cancelled', 'expired'])) {
                    Log::info("Transaksi order_id: $orderId sudah dalam status final '{$transaksi->status}'. Callback diabaikan.");
                    return ['status_code' => 200, 'message' => 'Transaksi sudah diproses sebelumnya.'];
                }

                $updateData = [];
                $newStatus = $transaksi->status; // Default ke status yang ada

                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'accept') {
                        $newStatus = 'paid';
                        Log::info("Pembayaran CAPTURE diterima (fraud accept) untuk order_id: $orderId.");
                    } else if ($fraudStatus == 'challenge') {
                        $newStatus = 'challenge';
                        Log::warning("Pembayaran CAPTURE butuh CHALLENGE (fraud review) untuk order_id: $orderId.");
                    } else {
                        $newStatus = 'failed';
                        Log::error("Pembayaran CAPTURE DITOLAK (fraud) untuk order_id: $orderId.");
                    }
                } elseif ($transactionStatus == 'settlement') {
                    $newStatus = 'paid';
                    Log::info("Pembayaran SETTLEMENT diterima untuk order_id: $orderId.");
                } elseif ($transactionStatus == 'pending') {
                    $newStatus = 'pending'; // Sebenarnya tidak perlu diupdate jika sudah pending, tapi untuk kelengkapan
                    Log::info("Pembayaran PENDING untuk order_id: $orderId.");
                } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                    if ($transactionStatus == 'deny') $newStatus = 'failed';
                    if ($transactionStatus == 'cancel') $newStatus = 'cancelled';
                    if ($transactionStatus == 'expire') $newStatus = 'expired';
                    Log::warning("Pembayaran '$transactionStatus' untuk order_id: $orderId. Status diubah menjadi '$newStatus'.");
                } else {
                    Log::info("Status transaksi tidak dikenal atau tidak memerlukan aksi khusus: '$transactionStatus' untuk order_id: $orderId");
                    return ['status_code' => 200, 'message' => 'Status transaksi tidak memerlukan aksi.'];
                }
                
                $updateData['status'] = $newStatus;

                // Simpan perubahan status transaksi jika ada perubahan
                if ($transaksi->status !== $newStatus) {
                    $originalStatus = $transaksi->status;
                    $transaksi->fill($updateData); // Hanya update status di sini
                    if (!$transaksi->save()) {
                        // Gagal simpan status, exception akan me-rollback transaksi DB
                        throw new \Exception("Gagal menyimpan status '{$newStatus}' untuk transaksi order_id: $orderId");
                    }
                    Log::info("Status transaksi order_id: $orderId berhasil diubah dari '{$originalStatus}' menjadi '{$transaksi->status}'.");
                } else {
                     Log::info("Tidak ada perubahan status untuk transaksi order_id: $orderId. Status tetap '{$transaksi->status}'.");
                }


                // Proses pengurangan stok HANYA jika status menjadi 'paid'
                if ($transaksi->status === 'paid') {
                    Log::info("Memulai proses pengurangan stok untuk order_id: $orderId karena status 'paid'.");

                    if (is_null($transaksi->barang_id)) {
                        Log::error("barang_id pada transaksi order_id: $orderId adalah NULL. Stok tidak dapat dikurangi.");
                        // Pertimbangkan apakah ini seharusnya menjadi exception tergantung logika bisnis
                    } else {
                        $barang = Barang::find($transaksi->barang_id);
                        if ($barang) {
                            Log::info("Barang ditemukan: {$barang->nama_barang} (ID: {$barang->id}). Stok saat ini: {$barang->stok}. Jumlah sewa: {$transaksi->jumlah_sewa}");

                            if (!is_numeric($transaksi->jumlah_sewa) || $transaksi->jumlah_sewa <= 0) {
                                Log::warning("Jumlah sewa tidak valid ({$transaksi->jumlah_sewa}) untuk transaksi order_id: $orderId. Stok tidak diubah.");
                            } else {
                                if ($barang->stok < $transaksi->jumlah_sewa) {
                                    Log::error("Stok barang {$barang->nama_barang} (ID: {$barang->id}) tidak mencukupi ({$barang->stok}) untuk dikurangi {$transaksi->jumlah_sewa} pada transaksi order_id: $orderId. Stok tidak diubah.");
                                    // Pertimbangkan apakah ini seharusnya menjadi exception
                                    // throw new \Exception("Stok barang tidak mencukupi saat callback untuk order_id: $orderId");
                                } else {
                                    $barang->stok -= $transaksi->jumlah_sewa;
                                    if (!$barang->save()) {
                                        // Gagal simpan stok, exception akan me-rollback transaksi DB
                                        throw new \Exception("Gagal menyimpan perubahan stok untuk barang ID: {$barang->id} pada transaksi order_id: $orderId.");
                                    }
                                    Log::info("Stok barang {$barang->nama_barang} (ID: {$barang->id}) berhasil dikurangi sebanyak: {$transaksi->jumlah_sewa}. Stok baru: {$barang->stok} untuk order_id: $orderId.");
                                }
                            }
                        } else {
                            Log::warning("Barang dengan ID: {$transaksi->barang_id} tidak ditemukan untuk transaksi order_id: $orderId. Stok tidak dikurangi.");
                            // Pertimbangkan apakah ini seharusnya menjadi exception
                        }
                    }
                }
                return ['status_code' => 200, 'message' => 'Callback berhasil diproses'];
            }); // Akhir dari DB::transaction

            return response()->json(['message' => $result['message']], $result['status_code']);

        } catch (\Exception $e) {
            // DB::rollBack() sudah otomatis dipanggil oleh DB::transaction jika ada exception
            Log::error("Error dalam memproses callback untuk order_id: {$orderId}. Pesan: " . $e->getMessage(), [
                'payload' => $payload,
                'trace' => $e->getTraceAsString() // Untuk debugging lebih detail jika perlu
            ]);
            // Return 500 agar Midtrans mungkin mencoba mengirim ulang notifikasi (tergantung konfigurasi retry Midtrans)
            return response()->json(['message' => 'Terjadi kesalahan internal saat memproses callback.'], 500);
        }
    }
}