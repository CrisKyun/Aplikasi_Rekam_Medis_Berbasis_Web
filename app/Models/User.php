<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'nik',
        'no_kk',
        'username',
        'password',
        'email',
        'role_id',
        'status',
        'expired_at',
        'tanggal_registrasi',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
