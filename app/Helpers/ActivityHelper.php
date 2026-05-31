<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityHelper
{
    public static function log(
        string $aksi,
        string $modul,
        string $deskripsi,
        $targetId   = null,
        $targetType = null
    ): void {
        ActivityLog::create([
            'user_id'     => session('user_id'),
            'aksi'        => $aksi,
            'modul'       => $modul,
            'deskripsi'   => $deskripsi,
            'ip_address'  => request()->ip(),
            'target_id'   => $targetId,
            'target_type' => $targetType,
        ]);
    }
}
