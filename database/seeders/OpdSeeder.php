<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpdSeeder extends Seeder
{
    public function run()
    {
        DB::table('opd')->insert([
            ['kode' => 'dukcapil', 'nama' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['kode' => 'naker', 'nama' => 'Dinas Tenaga Kerja'],
            ['kode' => 'rsud', 'nama' => 'RSUD Andi Makkasau Parepare'],
            ['kode' => 'bacukiki', 'nama' => 'Kecamatan Bacukiki'],
            ['kode' => 'bacukiki_barat', 'nama' => 'Kecamatan Bacukiki Barat'],
            ['kode' => 'ujung', 'nama' => 'Kecamatan Ujung'],
            ['kode' => 'soreang', 'nama' => 'Kecamatan Soreang'],
        ]);
    }
}