<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Dokter;
use App\Models\User;
use App\Models\Pendaftaran;

class DokterController extends Controller
{
    public function dashboard()
    {
        $totalPasien     = Pasien::count();
        $totalRekamMedis = RekamMedis::count();
        $pasienTerbaru   = Pasien::latest()->take(5)->get();

        return view('dokter.dashboard', compact('totalPasien', 'totalRekamMedis', 'pasienTerbaru'));
    }

    public function pasienIndex(Request $request)
    {
        $search = $request->search;

        $pasien = Pasien::when($search, function ($query) use ($search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%');
        })->latest()->paginate(10);

        return view('dokter.pasien.index', compact('pasien', 'search'));
    }

    public function pasienShow($id)
    {
        $pasien = Pasien::with(['rekamMedis' => function ($q) {
            $q->orderBy('tanggal_periksa', 'asc');
        }, 'rekamMedis'])->findOrFail($id);

        $dokter     = Dokter::all();
        $grafikData = $this->buildGrafikData($pasien->rekamMedis);

        return view('dokter.pasien.show', compact('pasien', 'dokter', 'grafikData'));
    }

    private function buildGrafikData($rekamMedis)
    {
        $labels     = [];
        $beratBadan = [];
        $suhuTubuh  = [];
        $sistolik   = [];
        $diastolik  = [];
        $bmi        = [];

        foreach ($rekamMedis as $rm) {
            $labels[] = \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y');

            $beratBadan[] = $rm->berat_badan ?? null;
            $suhuTubuh[]  = $rm->suhu_tubuh ?? null;

            if ($rm->tekanan_darah && str_contains($rm->tekanan_darah, '/')) {
                [$sis, $dia] = explode('/', $rm->tekanan_darah);
                $sistolik[]  = (int) trim($sis);
                $diastolik[] = (int) trim($dia);
            } else {
                $sistolik[]  = null;
                $diastolik[] = null;
            }

            if ($rm->berat_badan && $rm->tinggi_badan) {
                $tinggim = $rm->tinggi_badan / 100;
                $bmi[]   = round($rm->berat_badan / ($tinggim * $tinggim), 1);
            } else {
                $bmi[] = null;
            }
        }

        return compact('labels', 'beratBadan', 'suhuTubuh', 'sistolik', 'diastolik', 'bmi');
    }

    public function rekamMedisCreate($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        $dokter = Dokter::all();

        return view('dokter.rekam-medis.create', compact('pasien', 'dokter'));
    }

public function rekamMedisStore(Request $request, $pasienId)
{
    $request->validate([
        'tanggal_periksa' => 'required|date',
        'dokter'          => 'required|string',
        'keluhan'         => 'required|string',
        'kode_icd10'      => 'nullable|string|max:10',
        'nama_icd10'      => 'nullable|string|max:255',
        'diagnosis'       => 'nullable|string',
    ]);

    // Ambil pasien DULU sebelum create
    $pasien = Pasien::findOrFail($pasienId);

    // Simpan ke variabel $rekamMedis
    $rekamMedis = RekamMedis::create([
        'pasien_id'       => $pasienId,
        'tanggal_periksa' => $request->tanggal_periksa,
        'dokter'          => $request->dokter,
        'keluhan'         => $request->keluhan,
        'tekanan_darah'   => $request->tekanan_darah,
        'berat_badan'     => $request->berat_badan,
        'tinggi_badan'    => $request->tinggi_badan,
        'suhu_tubuh'      => $request->suhu_tubuh,
        'kode_icd10'      => $request->kode_icd10,
        'nama_icd10'      => $request->nama_icd10,
        'diagnosis'       => $request->diagnosis,
        'resep_obat'      => $request->resep_obat,
        'catatan_dokter'  => $request->catatan_dokter,
    ]);

    // Sekarang $rekamMedis->id & $pasien->nama_lengkap sudah tersedia
    \App\Helpers\ActivityHelper::log(
        'tambah_rekam_medis',
        'rekam_medis',
        "Menambahkan rekam medis untuk pasien: {$pasien->nama_lengkap}",
        $rekamMedis->id,
        'RekamMedis'
    );

    // Otomatis aktifkan akun pasien
    $user = User::find($pasien->user_id);
    if ($user) {
        User::where('id', $user->id)->update([
            'status'     => 'aktif',
            'expired_at' => null,
        ]);
    }

    return redirect('/dokter/pasien/' . $pasienId)
        ->with('success', 'Rekam medis berhasil ditambahkan!');
}

    public function rekamMedisEdit($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);
        $dokter     = Dokter::all();

        return view('dokter.rekam-medis.edit', compact('rekamMedis', 'dokter'));
    }

    public function rekamMedisUpdate(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $request->validate([
            'tanggal_periksa' => 'required|date',
            'dokter'          => 'required|string',
            'keluhan'         => 'required|string',
            'kode_icd10'      => 'nullable|string|max:10',
            'nama_icd10'      => 'nullable|string|max:255',
            'diagnosis'       => 'nullable|string',
        ]);

        $rekamMedis->update([
            'tanggal_periksa' => $request->tanggal_periksa,
            'dokter'          => $request->dokter,
            'keluhan'         => $request->keluhan,
            'tekanan_darah'   => $request->tekanan_darah,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'suhu_tubuh'      => $request->suhu_tubuh,
            'kode_icd10'    => $request->kode_icd10,
            'nama_icd10'    => $request->nama_icd10,
            'diagnosis'     => $request->diagnosis,
            'resep_obat'      => $request->resep_obat,
            'catatan_dokter'  => $request->catatan_dokter,
        ]);

        \App\Helpers\ActivityHelper::log(
            'edit_rekam_medis',
            'rekam_medis',
            "Mengubah rekam medis ID: {$id} pasien: {$rekamMedis->pasien->nama_lengkap}",
            $id,
            'RekamMedis'
        );

        return redirect('/dokter/pasien/' . $rekamMedis->pasien_id)->with('success', 'Rekam medis berhasil diperbarui!');
    }

    public function rekamMedisDestroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $pasienId   = $rekamMedis->pasien_id;
        \App\Helpers\ActivityHelper::log(
            'hapus_rekam_medis',
            'rekam_medis',
            "Menghapus rekam medis ID: {$id} pasien: {$rekamMedis->pasien->nama_lengkap}",
            $id,
            'RekamMedis'
        );
        $rekamMedis->delete();

        return redirect('/dokter/pasien/' . $pasienId)->with('success', 'Rekam medis berhasil dihapus!');
    }

    // ================================
    // PENGATURAN STATUS PASIEN
    // ================================
    public function toggleStatusPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        $user   = User::findOrFail($pasien->user_id);

        $statusBaru = $user->status === 'aktif' ? 'nonaktif' : 'aktif';

        // Pakai query langsung biar pasti tersimpan
        User::where('id', $user->id)->update(['status' => $statusBaru]);

        \App\Helpers\ActivityHelper::log(
            'toggle_status_pasien',
            'pasien',
            "Mengubah status akun pasien: {$pasien->nama_lengkap} menjadi {$statusBaru}",
            $pasien->id,
            'Pasien'
        );

        $pesan = $statusBaru === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect('/dokter/pasien/' . $id)->with('success', "Akun pasien berhasil {$pesan}!");
    }

    // ================================
    // PENGATURAN KLINIK
    // ================================
    public function klinikEdit()
    {
        $klinik = \App\Models\InfoKlinik::first();
        $jamOperasional = $klinik ? json_decode($klinik->jam_operasional, true) : [
            'Senin - Jumat' => '08.00 - 16.00',
            'Sabtu'         => '08.00 - 13.00',
            'Minggu'        => 'Tutup',
        ];

        return view('dokter.klinik.edit', compact('klinik', 'jamOperasional'));
    }

    public function klinikUpdate(Request $request)
    {
        $request->validate([
            'nama_klinik' => 'required|string|max:100',
            'alamat'      => 'required|string',
            'no_telepon'  => 'required|string|max:15',
        ], [
            'nama_klinik.required' => 'Nama klinik wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_telepon.required'  => 'No. telepon wajib diisi.',
        ]);

        // Susun jam operasional dari input
        $jamOperasional = [];
        foreach ($request->hari as $index => $hari) {
            if (!empty($hari)) {
                $jamOperasional[$hari] = $request->jam[$index];
            }
        }

        $klinik = \App\Models\InfoKlinik::first();

        if ($klinik) {
            $klinik->update([
                'nama_klinik'     => $request->nama_klinik,
                'alamat'          => $request->alamat,
                'no_telepon'      => $request->no_telepon,
                'email'           => $request->email,
                'deskripsi'       => $request->deskripsi,
                'jam_operasional' => json_encode($jamOperasional),
            ]);
        } else {
            \App\Models\InfoKlinik::create([
                'nama_klinik'     => $request->nama_klinik,
                'alamat'          => $request->alamat,
                'no_telepon'      => $request->no_telepon,
                'email'           => $request->email,
                'deskripsi'       => $request->deskripsi,
                'jam_operasional' => json_encode($jamOperasional),
            ]);
        }

        return redirect('/dokter/klinik')->with('success', 'Informasi klinik berhasil diperbarui!');
    }

    // ================================
    // KELOLA DOKTER
    // ================================
    public function dokterIndex()
    {
        $dokter = Dokter::with('jadwalDokter')->get();
        return view('dokter.kelola-dokter.index', compact('dokter'));
    }

    public function dokterCreate()
    {
        return view('dokter.kelola-dokter.create');
    }

    public function dokterStore(Request $request)
    {
        $request->validate([
            'nama_dokter'  => 'required|string|max:50',
            'bidang_medis' => 'required|string|max:50',
        ]);

        $dokter = Dokter::create([
            'nama_dokter'  => $request->nama_dokter,
            'no_hp'        => $request->no_hp,
            'bidang_medis' => $request->bidang_medis,
        ]);

        // Simpan jadwal
        if ($request->hari) {
            foreach ($request->hari as $index => $hari) {
                if (!empty($hari)) {
                    \App\Models\JadwalDokter::create([
                        'dokter_id'   => $dokter->id,
                        'hari'        => $hari,
                        'jam_mulai'   => $request->jam_mulai[$index],
                        'jam_selesai' => $request->jam_selesai[$index],
                        'status'      => 'Aktif',
                    ]);
                }
            }
        }

        return redirect('/dokter/kelola-dokter')->with('success', 'Data dokter berhasil ditambahkan!');
    }

    public function dokterEdit($id)
    {
        $dokter = Dokter::with('jadwalDokter')->findOrFail($id);
        return view('dokter.kelola-dokter.edit', compact('dokter'));
    }

    public function dokterUpdate(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'nama_dokter'  => 'required|string|max:50',
            'bidang_medis' => 'required|string|max:50',
        ]);

        $dokter->update([
            'nama_dokter'  => $request->nama_dokter,
            'no_hp'        => $request->no_hp,
            'bidang_medis' => $request->bidang_medis,
        ]);

        // Hapus jadwal lama, simpan yang baru
        \App\Models\JadwalDokter::where('dokter_id', $id)->delete();

        if ($request->hari) {
            foreach ($request->hari as $index => $hari) {
                if (!empty($hari)) {
                    \App\Models\JadwalDokter::create([
                        'dokter_id'   => $id,
                        'hari'        => $hari,
                        'jam_mulai'   => $request->jam_mulai[$index],
                        'jam_selesai' => $request->jam_selesai[$index],
                        'status'      => 'Aktif',
                    ]);
                }
            }
        }

        return redirect('/dokter/kelola-dokter')->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function dokterDestroy($id)
    {
        Dokter::findOrFail($id)->delete();
        return redirect('/dokter/kelola-dokter')->with('success', 'Data dokter berhasil dihapus!');
    }

    // ================================
    // ANTRIAN
    // ================================
    public function antrianIndex(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');
        $dokterId = $request->dokter_id;

        $antrian = Pendaftaran::with(['pasien', 'dokter'])
            ->when($dokterId, fn($q) => $q->where('dokter_id', $dokterId))
            ->where('tanggal_kunjungan', $tanggal)
            ->orderBy('nomor_antrian')
            ->get();

        $dokter = Dokter::all();

        return view('dokter.antrian.index', compact('antrian', 'tanggal', 'dokter', 'dokterId'));
    }

    public function antrianPanggil($id)
    {
        $antrian = Pendaftaran::findOrFail($id);
        $antrian->update(['status_antrian' => 'dipanggil']);

        \App\Helpers\ActivityHelper::log(
            'panggil_antrian',
            'antrian',
            "Memanggil antrian no: {$antrian->nomor_antrian} pasien: {$antrian->pasien->nama_lengkap}",
            $antrian->id,
            'Pendaftaran'
        );

        return redirect()->back()->with('success', 'Pasien berhasil dipanggil!');
    }

    public function antrianSelesai($id)
    {
        $antrian = Pendaftaran::findOrFail($id);
        $antrian->update(['status_antrian' => 'selesai']);

        \App\Helpers\ActivityHelper::log(
            'selesai_antrian',
            'antrian',
            "Menyelesaikan antrian no: {$antrian->nomor_antrian} pasien: {$antrian->pasien->nama_lengkap}",
            $antrian->id,
            'Pendaftaran'
        );

        return redirect()->back()->with('success', 'Antrian selesai!');
    }

    public function antrianBatal(Request $request, $id)
    {
        $antrian = Pendaftaran::findOrFail($id);
        $antrian->update([
            'status_antrian'        => 'batal',
            'keterangan_pembatalan' => $request->keterangan ?? 'Dibatalkan oleh dokter.',
        ]);

        return redirect()->back()->with('success', 'Antrian dibatalkan.');
    }

    public function antrianEditEstimasi($id)
    {
        $antrian = Pendaftaran::with(['pasien', 'dokter'])->findOrFail($id);
        return view('dokter.antrian.edit-estimasi', compact('antrian'));
    }

    public function antrianUpdateEstimasi(Request $request, $id)
    {
        $request->validate([
            'jam_mulai_baru' => 'required|date_format:H:i',
        ], [
            'jam_mulai_baru.required'    => 'Jam mulai wajib diisi.',
            'jam_mulai_baru.date_format' => 'Format jam tidak valid.',
        ]);

        $antrian = Pendaftaran::findOrFail($id);

        // Ambil semua antrian di dokter & tanggal yang sama, urut nomor
        $semuaAntrian = Pendaftaran::where('dokter_id', $antrian->dokter_id)
            ->where('tanggal_kunjungan', $antrian->tanggal_kunjungan)
            ->whereIn('status_antrian', ['menunggu', 'dipanggil'])
            ->orderBy('nomor_antrian')
            ->get();

        // Hitung ulang estimasi semua antrian mulai dari jam_mulai_baru
        $jamMulai = \Carbon\Carbon::createFromFormat('H:i', $request->jam_mulai_baru);

        foreach ($semuaAntrian as $index => $a) {
            $estimasiBaru = $jamMulai->copy()->addMinutes($index * 15)->format('H:i');
            Pendaftaran::where('id', $a->id)->update(['estimasi_jam' => $estimasiBaru]);
        }

        return redirect('/dokter/antrian?tanggal=' . $antrian->tanggal_kunjungan)
            ->with('success', 'Estimasi waktu semua antrian berhasil diperbarui!');
    }
}
