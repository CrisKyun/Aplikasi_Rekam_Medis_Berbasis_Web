<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoKlinikSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('info_klinik')->insert([
            'nama_klinik'      => 'Klinik Sehat Bersama',
            'alamat'           => 'Jl. Kesehatan No. 1, Banyuwangi',
            'no_telepon'       => '0333-123456',
            'email'            => 'info@kliniksehat.com',
            'jam_operasional'  => json_encode([
                'Senin - Jumat' => '08.00 - 16.00',
                'Sabtu'         => '08.00 - 13.00',
                'Minggu'        => 'Tutup',
            ]),
            'deskripsi'        => 'Klinik Sehat Bersama melayani pasien umum dan BPJS dengan tenaga medis berpengalaman.',
        ]);
    }
}
