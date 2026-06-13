<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use Carbon\Carbon;

class AntriController extends Controller
{
    // Halaman daftar antrian pasien
    public function index()
    {
        $antrian = Pendaftaran::whereHas('pasien', function ($q) {
            $q->where('user_id', session('user_id'));
        })
            ->with(['pasien', 'dokter'])
            ->orderByDesc('created_at')
            ->get();

        return view('antrian.index', compact('antrian'));
    }

    // Form daftar antrian
    public function create()
    {
        // Cek status akun
        $user = \App\Models\User::find(session('user_id'));
        if ($user->status !== 'aktif') {
            return redirect('/antrian')->with('error', 'Akun Anda nonaktif. Hubungi klinik untuk mengaktifkan.');
        }

        // Cek jam operasional hari ini
        $klinik = \App\Models\InfoKlinik::first();
        $klinikTutup = false;
        $pesanTutup  = '';

        if ($klinik && $klinik->jam_operasional) {
            $jamOps  = json_decode($klinik->jam_operasional, true);
            $hariIni = \Carbon\Carbon::now()->locale('id');

            $hariMap = [
                'Monday'    => ['Senin', 'Senin - Jumat', 'Senin - Sabtu'],
                'Tuesday'   => ['Selasa', 'Senin - Jumat', 'Senin - Sabtu'],
                'Wednesday' => ['Rabu', 'Senin - Jumat', 'Senin - Sabtu'],
                'Thursday'  => ['Kamis', 'Senin - Jumat', 'Senin - Sabtu'],
                'Friday'    => ['Jumat', 'Senin - Jumat', 'Senin - Sabtu'],
                'Saturday'  => ['Sabtu', 'Senin - Sabtu'],
                'Sunday'    => ['Minggu'],
            ];

            $namaHariEn   = \Carbon\Carbon::now()->format('l');
            $kemungkinan  = $hariMap[$namaHariEn] ?? [];
            $jamHariIni   = null;

            foreach ($kemungkinan as $key) {
                if (isset($jamOps[$key])) {
                    $jamHariIni = $jamOps[$key];
                    break;
                }
            }

            if (!$jamHariIni || strtolower($jamHariIni) === 'tutup') {
                $klinikTutup = true;
                $pesanTutup  = 'Klinik tutup hari ini. Silakan daftar antrian di hari lain.';
            }
        }

        // Tanggal tersedia: hari ini s/d H+3
        // Filter hanya hari yang dokternya praktik
        $tanggalTersedia = [];
        for ($i = 0; $i <= 3; $i++) {
            $tgl        = \Carbon\Carbon::now()->addDays($i);
            $namaHariEn = $tgl->format('l');
            $hariMap    = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu',
            ];
            $hariIndonesia = $hariMap[$namaHariEn];

            // Cek apakah ada dokter yang praktik hari itu
            $adaDokter = \App\Models\JadwalDokter::where('hari', $hariIndonesia)
                ->where('status', 'Aktif')
                ->exists();

            // Cek jam operasional klinik hari itu
            $kemungkinanHari = $hariMap[$namaHariEn] ?? $hariIndonesia;
            $jamHariTersebut = null;

            if ($klinik && $klinik->jam_operasional) {
                $jamOps = json_decode($klinik->jam_operasional, true);
                $kemungkinanKeys = [
                    $hariIndonesia,
                    'Senin - Jumat',
                    'Senin - Sabtu',
                ];
                foreach ($kemungkinanKeys as $key) {
                    if (isset($jamOps[$key])) {
                        $jamHariTersebut = $jamOps[$key];
                        break;
                    }
                }
            }

            $kliniKBuka = $jamHariTersebut && strtolower($jamHariTersebut) !== 'tutup';

            if ($adaDokter && $kliniKBuka) {
                $tanggalTersedia[] = [
                    'nilai' => $tgl->format('Y-m-d'),
                    'label' => $tgl->translatedFormat('l, d M Y') . ' (' . ($jamHariTersebut ?? '') . ')',
                    'hari'  => $hariIndonesia,
                ];
            }
        }

        $anggotaKeluarga = \App\Models\Pasien::where('user_id', session('user_id'))->get();
        $dokter          = \App\Models\Dokter::with('jadwalDokter')->get();

        return view('antrian.create', compact(
            'anggotaKeluarga',
            'dokter',
            'tanggalTersedia',
            'klinikTutup',
            'pesanTutup'
        ));
    }

    // Simpan antrian
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id'         => 'required|exists:pasien,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_awal'      => 'required|string|max:500',
        ], [
            'pasien_id.required'         => 'Pilih anggota keluarga.',
            'dokter_id.required'         => 'Pilih dokter.',
            'tanggal_kunjungan.required' => 'Pilih tanggal kunjungan.',
            'keluhan_awal.required'      => 'Keluhan wajib diisi.',
        ]);

        // Pastikan pasien milik user yang login
        $pasien = Pasien::where('id', $request->pasien_id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // Cek jadwal dokter di hari itu
        $tanggal    = Carbon::parse($request->tanggal_kunjungan);
        $namaHari   = $tanggal->locale('id')->dayName;
        $namaHariEn = $tanggal->format('l'); // English

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $hariIndonesia = $hariMap[$namaHariEn];

        $jadwal = JadwalDokter::where('dokter_id', $request->dokter_id)
            ->where('hari', $hariIndonesia)
            ->where('status', 'Aktif')
            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Dokter tidak praktik pada hari tersebut.')->withInput();
        }

        // Cek apakah pasien sudah punya antrian di hari & dokter yang sama
        $sudahAntri = Pendaftaran::where('pasien_id', $pasien->id)
            ->where('dokter_id', $request->dokter_id)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->whereIn('status_antrian', ['menunggu', 'dipanggil'])
            ->exists();

        if ($sudahAntri) {
            return back()->with('error', 'Pasien sudah memiliki antrian untuk dokter dan tanggal ini.')->withInput();
        }

        // Hitung nomor antrian
        $nomorTerakhir = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->whereIn('status_antrian', ['menunggu', 'dipanggil', 'selesai'])
            ->max('nomor_antrian') ?? 0;

        $nomorAntrian = $nomorTerakhir + 1;

        // Hitung estimasi jam (tiap pasien 15 menit)
        $jamMulai    = Carbon::parse($jadwal->jam_mulai);
        $estimasiJam = $jamMulai->addMinutes(($nomorAntrian - 1) * 15)->format('H:i');

        Pendaftaran::create([
            'pasien_id'         => $pasien->id,
            'dokter_id'         => $request->dokter_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'nomor_antrian'     => $nomorAntrian,
            'estimasi_jam'      => $estimasiJam,
            'keluhan_awal'      => $request->keluhan_awal,
            'status_antrian'    => 'menunggu',
        ]);

        return redirect('/antrian')->with('success', "Berhasil daftar antrian! Nomor antrian Anda: {$nomorAntrian}, estimasi jam: {$estimasiJam}.");
    }

    // Batalkan antrian
    public function batal(Request $request, $id)
    {
        $antrian = Pendaftaran::whereHas('pasien', function ($q) {
            $q->where('user_id', session('user_id'));
        })->findOrFail($id);

        if (!in_array($antrian->status_antrian, ['menunggu'])) {
            return back()->with('error', 'Antrian tidak dapat dibatalkan.');
        }

        $antrian->update([
            'status_antrian'        => 'batal',
            'keterangan_pembatalan' => $request->keterangan ?? 'Dibatalkan oleh pasien.',
        ]);

        return redirect('/antrian')->with('success', 'Antrian berhasil dibatalkan.');
    }
}
