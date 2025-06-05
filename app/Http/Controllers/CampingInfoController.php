<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampingInfoController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Penyewaan Alat Camping',
            'paket_sewa' => [
                'Paket Hemat Solo (1 orang)',
                'Paket Pasangan (2 orang)',
                'Paket Keluarga/Teman (4–6 orang)',
                'Sewa Satuan (jika hanya butuh beberapa alat)'
            ],
            'lokasi_layanan' => 'Kami melayani penyewaan di wilayah sekitar Bandung, Bogor, Yogyakarta, dll. Antar-jemput alat bisa dilakukan ke lokasi Anda atau titik pertemuan tertentu.',
            'durasi_sewa' => [
                'Minimal sewa 1 hari',
                'Bisa disesuaikan dengan durasi pendakian/kemah',
                'Denda akan dikenakan jika keterlambatan mengembalikan'
            ],
            'kontak' => [
                'whatsapp' => '+62xxxxxxx',
                'instagram' => '@penyewaancamping.id',
                'facebook' => 'Penyewaan Camping ID',
                'email' => 'campingsewa@email.com'
            ],
            'tips' => [
                'Pastikan alat dalam kondisi baik saat diterima.',
                'Cek kelengkapan sesuai invoice/persetujuan awal.',
                'Jaga alat seperti milik sendiri agar tidak kena denda.'
            ]
        ];

        return view('camping-info', $data);
    }
}