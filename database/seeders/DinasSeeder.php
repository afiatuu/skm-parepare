<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DinasSeeder extends Seeder
{
    public function run(): void
    {
        // ambil id kategori
        $dinas      = DB::table('categories')->where('name', 'Dinas')->first();
        $kesehatan  = DB::table('categories')->where('name', 'Pelayanan Kesehatan')->first();
        $kecamatan  = DB::table('categories')->where('name', 'Kecamatan')->first();

        DB::table('dinas')->insert([
            // Kategori DINAS
            [
                'category_id' => $dinas->id,
                'nama'        => 'Dinas Tenaga Kerja',
                'singkatan'   => 'Disnaker',
            ],
            [
                'category_id' => $dinas->id,
                'nama'        => 'Dinas Kependudukan dan Pencatatan Sipil',
                'singkatan'   => 'Disdukcapil',
            ],

            // Kategori PELAYANAN KESEHATAN
            [
                'category_id' => $kesehatan->id,
                'nama'        => 'RSUD Andi Makkasau',
                'singkatan'   => 'RSUD',
            ],

            // Kategori KECAMATAN
            [
                'category_id' => $kecamatan->id,
                'nama'        => 'Kecamatan Ujung',
                'singkatan'   => 'Kec. Ujung',
            ],
            [
                'category_id' => $kecamatan->id,
                'nama'        => 'Kecamatan Soreang',
                'singkatan'   => 'Kec. Soreang',
            ],
            [
                'category_id' => $kecamatan->id,
                'nama'        => 'Kecamatan Bacukiki',
                'singkatan'   => 'Kec. Bacukiki',
            ],
            [
                'category_id' => $kecamatan->id,
                'nama'        => 'Kecamatan Bacukiki Barat',
                'singkatan'   => 'Kec. Bacukiki Barat',
            ],
        ]);
    }
}