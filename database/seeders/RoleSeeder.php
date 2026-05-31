<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nama_role' => 'superadmin'], // id: 1
            ['nama_role' => 'staff'],      // id: 2
            ['nama_role' => 'pasien'],     // id: 3
        ]);
    }
}
