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
        $user = \App\Models\User::find(session('user_id'));
        if ($user->status !== 'aktif') {
            return redirect('/antrian')->with('error', 'Akun Anda nonaktif.');
        }

        $klinik      = \App\Models\InfoKlinik::first();
        $klinikTutup = false;
        $pesanTutup  = '';

        if ($klinik && $klinik->jam_operasional) {
            $jamOps    = json_decode($klinik->jam_operasional, true);
            $hariIniEn = \Carbon\Carbon::now()->format('l'); // Monday, Tuesday, dst

            $hariMap = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu',
            ];

            $hariIndonesia = $hariMap[$hariIniEn];

            // Cek apakah ada key yang MENGANDUNG nama hari ini
            // Misalnya "Senin - Jumat Pagi", "Senin - Jumat Sore", "Sabtu Pagi", dll
            $adaYangBuka = false;

            foreach ($jamOps as $key => $jam) {
                // Skip kalau tutup
                if (strtolower(trim($jam)) === 'tutup') continue;

                // Cek apakah key ini relevan dengan hari ini
                if ($this->hariTercakup($hariIndonesia, $key)) {
                    $adaYangBuka = true;
                    break;
                }
            }

            if (!$adaYangBuka) {
                $klinikTutup = true;
                $pesanTutup  = "Klinik tutup hari {$hariIndonesia}. Silakan daftar di hari lain.";
            }
        }

        // Tanggal tersedia: hari ini s/d H+3
        $tanggalTersedia = [];
        for ($i = 0; $i <= 3; $i++) {
            $tgl           = \Carbon\Carbon::now()->addDays($i);
            $hariIniEn     = $tgl->format('l');
            $hariMap       = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu',
            ];
            $hariIndonesia = $hariMap[$hariIniEn];

            // Cek ada dokter praktik hari itu
            $adaDokter = \App\Models\JadwalDokter::where('hari', $hariIndonesia)
                ->where('status', 'Aktif')
                ->exists();

            // Cek klinik buka hari itu
            $klinikBukaHariItu = false;
            if ($klinik && $klinik->jam_operasional) {
                $jamOps = json_decode($klinik->jam_operasional, true);
                foreach ($jamOps as $key => $jam) {
                    if (strtolower(trim($jam)) === 'tutup') continue;
                    if ($this->hariTercakup($hariIndonesia, $key)) {
                        $klinikBukaHariItu = true;
                        break;
                    }
                }
            }

            if ($adaDokter && $klinikBukaHariItu) {
                $tanggalTersedia[] = [
                    'nilai' => $tgl->format('Y-m-d'),
                    'label' => $tgl->translatedFormat('l, d M Y'),
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

    // ================================
    // HELPER: Cek apakah hari tercakup dalam key jam operasional
    // ================================
    private function hariTercakup(string $hariIndonesia, string $key): bool
    {
        $key = strtolower($key);
        $hari = strtolower($hariIndonesia);

        // Cek langsung (contoh: "Minggu", "Sabtu Pagi")
        if (str_contains($key, $hari)) {
            return true;
        }

        // Mapping range hari
        $urutanHari = [
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6,
            'minggu' => 7,
        ];

        // Cek apakah key mengandung range "X - Y" (contoh: "senin - jumat")
        // Cari pattern "hari1 - hari2"
        foreach ($urutanHari as $h1 => $u1) {
            foreach ($urutanHari as $h2 => $u2) {
                $pattern = $h1 . ' - ' . $h2;
                if (str_contains($key, $pattern)) {
                    $urutanHariIni = $urutanHari[$hari] ?? 0;
                    if ($urutanHariIni >= $u1 && $urutanHariIni <= $u2) {
                        return true;
                    }
                }
            }
        }

        return false;
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
