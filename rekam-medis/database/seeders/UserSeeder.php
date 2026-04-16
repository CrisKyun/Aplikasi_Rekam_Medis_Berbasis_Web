<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // staff
        DB::table('user')->insert([
            'nik'                 => '3510000000000001',
            'no_kk'              => '3510000000000001',
            'username'           => 'Staff Klinik',
            'password'           => Hash::make('staff123'),
            'email'              => 'staff@klinik.com',
            'role_id'            => 1,
            'tanggal_registrasi' => now(),
        ]);

        // Pasien contoh
        DB::table('user')->insert([
            'nik'                => '3510123456789001',
            'no_kk'             => '3510123456789000',
            'username'          => 'Budi Santoso',
            'password'          => Hash::make('budi123'),
            'email'             => 'budi@email.com',
            'role_id'           => 3,
            'tanggal_registrasi' => now(),
        ]);
    }
}
