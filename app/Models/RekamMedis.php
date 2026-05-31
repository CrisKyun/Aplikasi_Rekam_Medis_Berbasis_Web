<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $fillable = [
        'pasien_id',
        'tanggal_periksa',
        'dokter',
        'keluhan',
        'tekanan_darah',
        'berat_badan',
        'tinggi_badan',
        'suhu_tubuh',
        'kode_icd10',
        'nama_icd10',
        'diagnosis',
        'resep_obat',
        'catatan_dokter',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
