<?php
// database\seeders\OpdSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpdSeeder extends Seeder
{
    // OpdSeeder.php
    // OpdSeeder.php
    public function run()
    {
        // ⚠️ PERBAIKAN: Ganti 'nama' menjadi 'name'
        $categoryDinas = DB::table('categories')->where('name', 'Dinas')->first();
        $categoryKesehatan = DB::table('categories')->where('name', 'Pelayanan Kesehatan')->first();
        $categoryKecamatan = DB::table('categories')->where('name', 'Kecamatan')->first();
        
        // Jika belum ada category, gunakan null atau default
        $catDinasId = $categoryDinas ? $categoryDinas->id : 1;
        $catKesId = $categoryKesehatan ? $categoryKesehatan->id : 2;
        $catKecId = $categoryKecamatan ? $categoryKecamatan->id : 3;

        DB::table('opd')->insert([
            [
                'kode' => 'dukcapil', 
                'nama' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'category_id' => $catDinasId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'naker', 
                'nama' => 'Dinas Tenaga Kerja',
                'category_id' => $catDinasId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'rsud', 
                'nama' => 'RSUD Andi Makkasau Parepare',
                'category_id' => $catKesId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'bacukiki', 
                'nama' => 'Kecamatan Bacukiki',
                'category_id' => $catKecId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'bacukiki_barat', 
                'nama' => 'Kecamatan Bacukiki Barat',
                'category_id' => $catKecId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'ujung', 
                'nama' => 'Kecamatan Ujung',
                'category_id' => $catKecId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'soreang', 
                'nama' => 'Kecamatan Soreang',
                'category_id' => $catKecId,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}