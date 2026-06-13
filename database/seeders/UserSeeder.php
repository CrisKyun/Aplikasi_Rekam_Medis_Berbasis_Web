<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        DB::table('users')->insert([
            'nik'                => '3510160202050001',
            'no_kk'             => null,
            'username'          => 'superadmin',
            'nama_lengkap'      => 'Super Admin',
            'password'          => Hash::make('Mupp!qy0ech4y'),
            'email'             => 'halofajar02@gmail.com',
            'role_id'           => 1,
            'status'            => 'aktif',
            'tanggal_registrasi' => now(),
        ]);

        // Staff contoh
        DB::table('users')->insert([
            'nik'                => '3510164611690003',
            'no_kk'             => null,
            'username'          => 'dokterluria',
            'nama_lengkap'      => 'dr. Luria Widijana Haribawanti',
            'password'          => Hash::make('luriadokter0606@'),
            'email'             => 'widijanaluria@gmail.com',
            'role_id'           => 2,
            'status'            => 'aktif',
            'tanggal_registrasi' => now(),
        ]);

        // Pasien contoh
        DB::table('users')->insert([
            'nik'                => '3510123456789001',
            'no_kk'             => '3510123456789000',
            'username'          => 'Budi Santoso',
            'nama_lengkap'      => 'Budi Santoso',
            'password'          => Hash::make('budi123'),
            'email'             => 'budi@email.com',
            'role_id'           => 3,
            'status'            => 'aktif',
            'expired_at'        => now()->addDays(7),
            'tanggal_registrasi' => now(),
        ]);
    }
}
