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

        $view->with('badgeAntrian', $antrianBaru);
    }
}
