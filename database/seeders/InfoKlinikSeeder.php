<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoKlinikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('info_klinik')->insert([
            'nama_klinik'      => 'Klinik dr. Luria Widijana Haribawanti',
            'alamat'           => 'Jl. Rinjani No.46, Singotrunan',
            'no_telepon'       => '081333037793',
            'email'            => 'widijanaluria@gmail.com',
            'jam_operasional'  => json_encode([
                'Senin - Jumat Pagi' => '07:00 - 09:30',
                'Senin - Jumat Sore' => '16:00 - 19:15',
                'Sabtu Pagi'         => '07:00 - 10:30',
                'Sabtu Sore'         => 'Tutup',
                'Minggu'        => 'Tutup',
            ]),
            'deskripsi'        => 'Klinik dr. Luria Widijana Haribawanti melayani pasien umum dengan memprioritaskan kualitas pelayanan dan etika dalam bekerja.',
        ]);
    }
}
