<?php

namespace App\Http\Controllers;

use App\Models\InfoKlinik;
use App\Models\Dokter;
use App\Models\JadwalDokter;

class HomeController extends Controller
{
    public function index()
    {
        $klinik = InfoKlinik::first();
        $dokter = Dokter::with('jadwalDokter')->get();

        return view('home', compact('klinik', 'dokter'));
    }
}
