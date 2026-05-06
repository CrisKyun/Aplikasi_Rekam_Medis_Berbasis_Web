<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pasien;
use Carbon\Carbon;

class NonaktifkanPasienIseng extends Command
{
    protected $signature   = 'pasien:nonaktifkan-iseng';
    protected $description = 'Nonaktifkan akun pasien yang belum pernah berobat selama 1 bulan';

    public function handle()
    {
        $users = User::where('role_id', 2)
            ->where('status', 'aktif')
            ->where('tanggal_registrasi', '<=', Carbon::now()->subMonth())
            ->get();

        $count = 0;

        foreach ($users as $user) {
            // Cek apakah punya rekam medis
            $punyaRekamMedis = Pasien::where('user_id', $user->id)
                ->whereHas('rekamMedis')
                ->exists();

            if (!$punyaRekamMedis) {
                // Pakai Eloquent update langsung
                User::where('id', $user->id)->update(['status' => 'nonaktif']);
                $count++;
            }
        }

        $this->info("Selesai! {$count} akun pasien dinonaktifkan.");
    }
}
