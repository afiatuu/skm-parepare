<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $disnaker   = DB::table('dinas')->where('nama', 'Dinas Tenaga Kerja')->first();
        $dukcapil   = DB::table('dinas')->where('nama', 'Dinas Kependudukan dan Pencatatan Sipil')->first();
        $rsud       = DB::table('dinas')->where('nama', 'RSUD Andi Makkasau')->first();

        // Disnaker
        DB::table('services')->insert([
            [
                'dinas_id' => $disnaker->id,
                'nama'     => 'Pengurusan Berkas',
            ],

            // Dukcapil
            [
                'dinas_id' => $dukcapil->id,
                'nama'     => 'Kartu Tanda Penduduk (KTP)',
            ],
            [
                'dinas_id' => $dukcapil->id,
                'nama'     => 'Kartu Keluarga (KK)',
            ],
            [
                'dinas_id' => $dukcapil->id,
                'nama'     => 'Akta Kelahiran',
            ],
            [
                'dinas_id' => $dukcapil->id,
                'nama'     => 'Akta Kematian',
            ],
            [
                'dinas_id' => $dukcapil->id,
                'nama'     => 'Akta Nikah',
            ],

            // RSUD Andi Makkasau
            [
                'dinas_id' => $rsud->id,
                'nama'     => 'Rawat Jalan',
            ],
            [
                'dinas_id' => $rsud->id,
                'nama'     => 'Rawat Inap',
            ],
            [
                'dinas_id' => $rsud->id,
                'nama'     => 'Gawat Darurat / IGD',
            ],
            [
                'dinas_id' => $rsud->id,
                'nama'     => 'Farmasi',
            ],
            [
                'dinas_id' => $rsud->id,
                'nama'     => 'Kamar Bersalin',
            ],
        ]);
    }
}