<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $fillable = ['user_id', 'nama_dokter', 'no_hp', 'bidang_medis'];

    public function jadwalDokter()
    {
        return $this->hasMany(JadwalDokter::class);
    }
}
