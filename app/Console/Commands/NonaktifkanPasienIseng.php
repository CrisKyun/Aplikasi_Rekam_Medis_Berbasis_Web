<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Pasien;
use Carbon\Carbon;

class NonaktifkanPasienIseng extends Command
{
    protected $signature   = 'pasien:nonaktifkan-iseng';
    protected $description = 'Nonaktifkan akun pasien yang expired dan belum pernah berobat';

    public function handle()
    {
        // Ambil user pasien yang aktif & sudah expired
        $users = User::where('role_id', 2)
            ->where('status', 'aktif')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', Carbon::now())
            ->get();

        $nonaktif = 0;
        $permanen  = 0;

        foreach ($users as $user) {
            $punyaRekamMedis = Pasien::where('user_id', $user->id)
                ->whereHas('rekamMedis')
                ->exists();

            if ($punyaRekamMedis) {
                // Sudah pernah berobat → jadikan permanen aktif
                User::where('id', $user->id)->update([
                    'expired_at' => null,
                ]);
                $permanen++;
            } else {
                // Belum pernah berobat → nonaktifkan
                User::where('id', $user->id)->update([
                    'status' => 'nonaktif',
                ]);
                $nonaktif++;
            }
        }

        $this->info("Selesai! {$nonaktif} akun dinonaktifkan, {$permanen} akun dijadikan permanen aktif.");
    }
}
