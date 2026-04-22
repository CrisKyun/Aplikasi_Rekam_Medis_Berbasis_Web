<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nama_role' => 'staff'],
            ['nama_role' => 'dokter'],
            ['nama_role' => 'pasien'],
        ]);
    }
}