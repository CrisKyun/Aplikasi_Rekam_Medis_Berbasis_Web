<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $dokterId = DB::table('dokter')->insertGetId([
            'user_id'      => null,
            'nama_dokter'  => 'dr. Luria Widijana Haribawanti',
            'no_hp'        => '081333037793',
            'bidang_medis' => 'Umum',
        ]);

        // Jadwal dokter
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        foreach ($hari as $h) {
            DB::table('jadwal_dokter')->insert([
                'dokter_id'   => $dokterId,
                'hari'        => $h,
                'jam_mulai'   => '07:00:00',
                'jam_selesai' => '19:15:00',
                'status'      => 'Aktif',
            ]);
        }
    }
}
