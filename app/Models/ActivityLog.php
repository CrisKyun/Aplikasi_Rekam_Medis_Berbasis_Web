<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table    = 'activity_log';
    protected $fillable = [
        'user_id',
        'aksi',
        'modul',
        'deskripsi',
        'ip_address',
        'target_id',
        'target_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
