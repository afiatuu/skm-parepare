<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan role admin ada, kalau belum dibuatkan
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],       // kolom unik
            ['description' => 'Administrator']  // kolom lain (opsional)
        );

        // buat / update user admin
        User::updateOrCreate(
            ['email' => 'admin@skm.test'], // kunci unik
            [
                'name'     => 'Administrator',
                'password' => Hash::make('iniadmin'),
                'role_id'  => $adminRole->id,
            ]
        );
    }
}
