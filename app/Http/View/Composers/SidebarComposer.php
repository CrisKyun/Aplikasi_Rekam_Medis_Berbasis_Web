<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class SidebarComposer
{
    public function compose(View $view): void
    {
        // Hitung antrian baru hari ini yang masih menunggu
        $antrianBaru = Pendaftaran::where('tanggal_kunjungan', Carbon::today())
            ->where('status_antrian', 'menunggu')
            ->count();

        // Pasien yang belum permanen (masih ada expired_at)
        $pasienBelumPermanen = \App\Models\User::where('role_id', 3)
            ->where('status', 'aktif')
            ->whereNotNull('expired_at')
            ->where('expired_at', '>', Carbon::now())
            ->count();

        $view->with('badgeAntrian', $antrianBaru);
        $view->with('badgePasienBaru', $pasienBelumPermanen);
    }
}
