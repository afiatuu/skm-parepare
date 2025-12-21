<?php
// database\seeders\ServiceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil OPD (kode sebagai PK)
        $dukcapil = DB::table('opd')->where('nama', 'Dinas Kependudukan dan Pencatatan Sipil')->first();
        $disnaker = DB::table('opd')->where('nama', 'Dinas Tenaga Kerja')->first();
        $rsud     = DB::table('opd')->where('nama', 'RSUD Andi Makkasau Parepare')->first();

        $kecamatan = DB::table('opd')
            ->whereIn('nama', [
                'Kecamatan Ujung',
                'Kecamatan Soreang',
                'Kecamatan Bacukiki',
                'Kecamatan Bacukiki Barat',
            ])
            ->get();

        $services = [];

        // ===============================
        // DUKCAPIL
        // ===============================
        if ($dukcapil) {
            $services = array_merge($services, [
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Akta Kelahiran'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Akta Kematian'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Akta Perceraian'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Akta Perkawinan'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Aktivasi Identitas Kependudukan Digital'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Kartu Identitas Anak (KIA)'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Kartu Keluarga (KK)'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Kerjasama Administrasi Kependudukan'],
                ['kode_opd' => $dukcapil->kode, 'nama' => 'Layanan Umum / Lainnya'],
            ]);
        }

        // ===============================
        // DISNAKER
        // ===============================
        if ($disnaker) {
            $services = array_merge($services, [
                ['kode_opd' => $disnaker->kode, 'nama' => 'Penanganan Sengketa Industrial'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pencatatan LKS Bipartit'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pencatatan Perjanjian Kerja Waktu Tertentu (PKWT)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pencatatan Serikat Buruh / Serikat Pekerja'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pendaftaran Perjanjian Kerja Bersama (PKB)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Penertiban Kartu Pencari Kerja (AK1)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Penetapan SK Tanda Daftar Bursa Kerja Khusus (BKK)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pengesahan Perjanjian Penempatan CPMI'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pendaftaran Perjanjian Pemborongan Pekerjaan (PPJP)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pengajuan Calon Pekerja Migran Indonesia (CPMI)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pengesahan Peraturan Perusahaan'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Rekomendasi Pembuatan Paspor CPMI Mandiri'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Rekomendasi Izin Pendirian Lembaga Pelatihan Kerja (LPK)'],
                ['kode_opd' => $disnaker->kode, 'nama' => 'Pelayanan Lainnya'],
            ]);
        }

        // ===============================
        // RSUD
        // ===============================
        if ($rsud) {
            $services = array_merge($services, [
                ['kode_opd' => $rsud->kode, 'nama' => 'Pelayanan Rawat Jalan'],
                ['kode_opd' => $rsud->kode, 'nama' => 'Pelayanan Rawat Inap'],
                ['kode_opd' => $rsud->kode, 'nama' => 'Pelayanan Gawat Darurat'],
                ['kode_opd' => $rsud->kode, 'nama' => 'Pelayanan Farmasi'],
                ['kode_opd' => $rsud->kode, 'nama' => 'Pelayanan Kamar Bersalin'],
            ]);
        }

        // ===============================
        // KECAMATAN
        // ===============================
        foreach ($kecamatan as $kec) {
            $services = array_merge($services, [
                ['kode_opd' => $kec->kode, 'nama' => 'Aktivasi Identitas Kependudukan Digital (IKD)'],
                ['kode_opd' => $kec->kode, 'nama' => 'Layanan Izin Keramaian'],
                ['kode_opd' => $kec->kode, 'nama' => 'Layanan Konsultasi dan Pengaduan'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Kartu Keluarga (KK)'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Kartu Identitas Anak (KIA)'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan KTP Pengajuan'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengumuman Perkawinan'],
                ['kode_opd' => $kec->kode, 'nama' => 'Perekaman KTP Pemula'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Dispensasi Nikah'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Surat Keterangan Tidak Mampu (SKTM)'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Surat Induk Kesenian'],
                ['kode_opd' => $kec->kode, 'nama' => 'Pengurusan Surat Keterangan Waris'],
            ]);
        }

        DB::table('services')->insert($services);
    }
}