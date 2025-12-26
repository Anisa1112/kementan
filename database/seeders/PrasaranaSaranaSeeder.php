<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrasaranaSarana;

class PrasaranaSaranaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'PSP001',
                'nama' => 'Irigasi Utama',
                'jenis' => 'Irigasi',
                'subsektor' => 'Tanaman Pangan',
                'status' => 'Aktif',
            ],
            [
                'kode' => 'PSP002',
                'nama' => 'Gudang Penyimpanan',
                'jenis' => 'Gudang',
                'subsektor' => 'Perkebunan',
                'status' => 'Aktif',
            ],
            [
                'kode' => 'PSP003',
                'nama' => 'Jalan Produksi',
                'jenis' => 'Jalan',
                'subsektor' => 'Hortikultura',
                'status' => 'Nonaktif',
            ],
            [
                'kode' => 'PSP004',
                'nama' => 'Kandang Ternak',
                'jenis' => 'Peternakan',
                'subsektor' => 'Peternakan',
                'status' => 'Aktif',
            ],
        ];

        foreach ($data as $item) {
            PrasaranaSarana::create($item);
        }
    }
}
