<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Pasien;

class RekamMedisController extends Controller
{
    // Form tambah rekam medis
    public function create($pasienId)
    {
        $pasien = Pasien::where('id', $pasienId)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('rekam-medis.create', compact('pasien'));
    }

    // Simpan rekam medis baru
    public function store(Request $request, $pasienId)
    {
        $request->validate([
            'tanggal_periksa' => 'required|date',
            'dokter'          => 'required|string|max:50',
            'keluhan'         => 'required|string',
            'diagnosis'       => 'required|string',
        ], [
            'tanggal_periksa.required' => 'Tanggal periksa wajib diisi.',
            'dokter.required'          => 'Nama dokter wajib diisi.',
            'keluhan.required'         => 'Keluhan wajib diisi.',
            'diagnosis.required'       => 'Diagnosis wajib diisi.',
        ]);

        $pasien = Pasien::where('id', $pasienId)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        RekamMedis::create([
            'pasien_id'       => $pasien->id,
            'tanggal_periksa' => $request->tanggal_periksa,
            'dokter'          => $request->dokter,
            'keluhan'         => $request->keluhan,
            'tekanan_darah'   => $request->tekanan_darah,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'suhu_tubuh'      => $request->suhu_tubuh,
            'diagnosis'       => $request->diagnosis,
            'resep_obat'      => $request->resep_obat,
            'catatan_dokter'  => $request->catatan_dokter,
        ]);

        return redirect('/pasien/' . $pasienId)->with('success', 'Rekam medis berhasil ditambahkan!');
    }

    // Detail rekam medis
    public function show($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);

        return view('rekam-medis.show', compact('rekamMedis'));
    }

    // Form edit rekam medis
    public function edit($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);

        // Pastikan pasien milik user yang login
        $pasien = Pasien::where('id', $rekamMedis->pasien_id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('rekam-medis.edit', compact('rekamMedis', 'pasien'));
    }

    // Simpan perubahan rekam medis
    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $pasien = Pasien::where('id', $rekamMedis->pasien_id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $request->validate([
            'tanggal_periksa' => 'required|date',
            'dokter'          => 'required|string|max:50',
            'keluhan'         => 'required|string',
            'diagnosis'       => 'required|string',
        ], [
            'tanggal_periksa.required' => 'Tanggal periksa wajib diisi.',
            'dokter.required'          => 'Nama dokter wajib diisi.',
            'keluhan.required'         => 'Keluhan wajib diisi.',
            'diagnosis.required'       => 'Diagnosis wajib diisi.',
        ]);

        $rekamMedis->update([
            'tanggal_periksa' => $request->tanggal_periksa,
            'dokter'          => $request->dokter,
            'keluhan'         => $request->keluhan,
            'tekanan_darah'   => $request->tekanan_darah,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'suhu_tubuh'      => $request->suhu_tubuh,
            'diagnosis'       => $request->diagnosis,
            'resep_obat'      => $request->resep_obat,
            'catatan_dokter'  => $request->catatan_dokter,
        ]);

        return redirect('/pasien/' . $pasien->id)->with('success', 'Rekam medis berhasil diperbarui!');
    }

    // Hapus rekam medis
    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        $pasien = Pasien::where('id', $rekamMedis->pasien_id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $pasienId = $rekamMedis->pasien_id;
        $rekamMedis->delete();

        return redirect('/pasien/' . $pasienId)->with('success', 'Rekam medis berhasil dihapus!');
    }
}
