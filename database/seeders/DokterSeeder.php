<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun user untuk dokter
        $userId = DB::table('users')->insertGetId([
            'nik'                => '3510000000000002',
            'no_kk'             => '3510000000000002',
            'username'          => 'dr. Siti Rahayu',
            'password'          => Hash::make('dokter123'),
            'email'             => 'siti@klinik.com',
            'role_id'           => 2,
            'tanggal_registrasi'=> now(),
        ]);

        // Data dokter
        $dokterId = DB::table('dokter')->insertGetId([
            'user_id'      => $userId,
            'nama_dokter'  => 'dr. Siti Rahayu',
            'no_hp'        => '081234567890',
            'bidang_medis' => 'Umum',
        ]);

        // Jadwal dokter
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        foreach ($hari as $h) {
            DB::table('jadwal_dokter')->insert([
                'dokter_id'   => $dokterId,
                'hari'        => $h,
                'jam_mulai'   => '08:00:00',
                'jam_selesai' => '16:00:00',
                'status'      => 'Aktif',
            ]);
        }
    }
}