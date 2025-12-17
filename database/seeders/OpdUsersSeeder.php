<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class OpdUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator'], ['description' => 'Operator OPD']);
        $kepalaRole = Role::firstOrCreate(['name' => 'kepala_opd'], ['description' => 'Kepala OPD']);

        // daftar OPD KODE (samakan dengan SurveyController kamu)
        $opds = [
            'dukcapil' => 'Dinas Kependudukan dan Pencatatan Sipil',
            'disnaker' => 'Dinas Tenaga Kerja',
            'rsud' => 'RSUD Andi Makkasau Parepare',
            'kec_bacukiki' => 'Kecamatan Bacukiki',
            'kec_bacukiki_barat' => 'Kecamatan Bacukiki Barat',
            'kec_ujung' => 'Kecamatan Ujung',
            'kec_soreang' => 'Kecamatan Soreang',
        ];

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@skm.test'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('iniadmin'),
                'role_id'  => $adminRole->id,
                'opd_kode' => null,
            ]
        );

        foreach ($opds as $kode => $nama) {
            // Operator
            User::updateOrCreate(
                ['email' => "operator_{$kode}@skm.test"],
                [
                    'name'     => "Operator {$nama}",
                    'password' => Hash::make('inioperator'),
                    'role_id'  => $operatorRole->id,
                    'opd_kode' => $kode,
                ]
            );

            // Kepala OPD
            User::updateOrCreate(
                ['email' => "kepala_{$kode}@skm.test"],
                [
                    'name'     => "Kepala {$nama}",
                    'password' => Hash::make('inikepala'),
                    'role_id'  => $kepalaRole->id,
                    'opd_kode' => $kode,
                ]
            );
        }
    }
}