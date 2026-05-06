<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Staff/Dokter
        DB::table('users')->insert([
            'nik'                => '0000000000000001',
            'no_kk'             => '0000000000000001',
            'username'          => 'Staff Klinik',
            'password'          => Hash::make('staff123'),
            'email'             => 'staff@klinik.com',
            'role_id'           => 1,
            'status'            => 'aktif', // ← staff selalu aktif
            'tanggal_registrasi' => now(),
        ]);

        // Akun Pasien contoh
        DB::table('users')->insert([
            'nik'                => '3510123456789001',
            'no_kk'             => '3510123456789000',
            'username'          => 'Budi Santoso',
            'password'          => Hash::make('budi123'),
            'email'             => 'budi@email.com',
            'role_id'           => 2,
            'status'            => 'aktif', // ← contoh sudah aktif
            'tanggal_registrasi' => now(),
        ]);
    }
}
