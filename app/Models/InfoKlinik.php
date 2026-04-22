<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoKlinik extends Model
{
    protected $table = 'info_klinik';
    protected $fillable = ['nama_klinik', 'alamat', 'no_telepon', 'email', 'jam_operasional', 'deskripsi', 'foto'];
}
