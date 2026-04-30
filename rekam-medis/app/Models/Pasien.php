<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kewarganegaraan',
        'agama',
        'pendidikan',
        'pekerjaan',
        'golongan_darah',
        'status_hubungan',
        'no_hp',
        'nama_ayah',
        'nama_ibu',
        'alamat',
        'rt',
        'rw',
        'kelurahan_desa',
        'kecamatan',
        'provinsi',
        'kode_pos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
