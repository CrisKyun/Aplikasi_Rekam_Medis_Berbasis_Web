<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua anggota keluarga berdasarkan user_id yang login
        $anggotaKeluarga = Pasien::where('user_id', session('user_id'))->get();

        return view('dashboard.index', compact('anggotaKeluarga'));
    }
}
