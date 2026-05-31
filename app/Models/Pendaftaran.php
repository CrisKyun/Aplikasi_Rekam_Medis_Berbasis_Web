<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_kunjungan',
        'nomor_antrian',
        'estimasi_jam',
        'keluhan_awal',
        'status_antrian',
        'keterangan_pembatalan',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
