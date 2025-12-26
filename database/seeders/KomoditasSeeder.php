<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komoditas;

class KomoditasSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // SEKTOR TANAMAN PANGAN
        // =========================
        Komoditas::create([
            'sektor' => 'Tanaman Pangan',
            'kode' => 'TPN',
            'status' => 'Aktif',
        ]);

        Komoditas::create([
            'sektor' => 'Tanaman Pangan',
            'subsektor' => 'Padi',
            'kode' => 'TPN-PD',
            'status' => 'Aktif',
        ]);

        Komoditas::create([
            'sektor' => 'Tanaman Pangan',
            'subsektor' => 'Plawija',
            'kode' => 'TPN-PLW',
            'status' => 'Aktif',
        ]);

        // =========================
        // SEKTOR HORTIKULTURA
        // =========================
        Komoditas::create([
            'sektor' => 'Hortikultura',
            'kode' => 'HRT',
            'status' => 'Aktif',
        ]);

        // =========================
        // SEKTOR PERKEBUNAN
        // =========================
        Komoditas::create([
            'sektor' => 'Perkebunan',
            'kode' => 'PKB',
            'status' => 'Aktif',
        ]);

        // =========================
        // SEKTOR PETERNAKAN
        // =========================
        Komoditas::create([
            'sektor' => 'Peternakan & Kesehatan Hewan',
            'kode' => 'PTN',
            'status' => 'Aktif',
        ]);

        // Subsektor Peternakan → Unggas
        Komoditas::create([
            'sektor' => 'Peternakan & Kesehatan Hewan',
            'subsektor' => 'Unggas',
            'kode' => 'PTN-UGS',
            'status' => 'Aktif',
        ]);

        // Kategori Ayam
        Komoditas::create([
            'sektor' => 'Peternakan & Kesehatan Hewan',
            'subsektor' => 'Unggas',
            'kategori' => 'Ayam',
            'kode' => 'PTN-UGS-AY',
            'status' => 'Aktif',
        ]);

        // Item Ayam Katek
        Komoditas::create([
            'sektor' => 'Peternakan & Kesehatan Hewan',
            'subsektor' => 'Unggas',
            'kategori' => 'Ayam',
            'item' => 'Ayam Katek',
            'kode' => 'PTN-UGS-AY-1',
            'nama_latin' => 'Gallus gallus',
            'status' => 'Aktif',
        ]);

        // Item Ayam Pelung
       Komoditas::create([
    'sektor' => 'Peternakan',
    'subsektor' => 'Unggas',
    'kategori' => 'Ayam',
    'item' => 'Ayam Katek',
    'kode' => 'PTN-UGS-AY-1',
    'nama_latin' => 'Gallus gallus',
    'status' => 'Aktif',
]);

    }
}
