<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    // Detail pasien + rekam medis
    public function show($id)
    {
        $pasien = Pasien::where('id', $id)
            ->where('user_id', session('user_id'))
            ->with('rekamMedis')
            ->firstOrFail();

        return view('pasien.show', compact('pasien'));
    }

    // Form tambah anggota keluarga
    public function create()
    {
        return view('pasien.create');
    }

    // Simpan anggota keluarga baru
    public function store(Request $request)
    {
        $request->validate([
            'nik'              => 'required|digits:16|unique:pasien,nik',
            'nama_lengkap'     => 'required|string|max:50',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_lahir'    => 'required|date',
            'status_hubungan'  => 'required',
        ], [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        ]);

        Pasien::create([
            'user_id'         => session('user_id'),
            'nik'             => $request->nik,
            'nama_lengkap'    => $request->nama_lengkap,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'agama'           => $request->agama,
            'golongan_darah'  => $request->golongan_darah ?? '-',
            'status_hubungan' => $request->status_hubungan,
            'no_hp'           => $request->no_hp,
            'alamat'          => $request->alamat,
            'kecamatan'       => $request->kecamatan,
            'provinsi'        => $request->provinsi,
        ]);

        return redirect('/dashboard')->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }
    // Form edit pasien
    public function edit($id)
    {
        $pasien = Pasien::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('pasien.edit', compact('pasien'));
    }

    // Simpan perubahan pasien
    public function update(Request $request, $id)
    {
        $pasien = Pasien::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $request->validate([
            'nik'             => 'required|digits:16|unique:pasien,nik,' . $id,
            'nama_lengkap'    => 'required|string|max:50',
            'jenis_kelamin'   => 'required|in:L,P',
            'tanggal_lahir'   => 'required|date',
            'status_hubungan' => 'required',
        ], [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        ]);

        $pasien->update([
            'nik'             => $request->nik,
            'nama_lengkap'    => $request->nama_lengkap,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'agama'           => $request->agama,
            'golongan_darah'  => $request->golongan_darah ?? '-',
            'status_hubungan' => $request->status_hubungan,
            'no_hp'           => $request->no_hp,
            'alamat'          => $request->alamat,
            'kecamatan'       => $request->kecamatan,
            'provinsi'        => $request->provinsi,
        ]);

        return redirect('/pasien/' . $id)->with('success', 'Data pasien berhasil diperbarui!');
    }

    // Hapus pasien
    public function destroy($id)
    {
        $pasien = Pasien::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $pasien->delete();

        return redirect('/dashboard')->with('success', 'Data pasien berhasil dihapus!');
    }
}
