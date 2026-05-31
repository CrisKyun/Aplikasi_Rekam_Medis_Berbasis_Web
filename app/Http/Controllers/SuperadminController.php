<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    // Daftar semua staff
    public function staffIndex()
    {
        $staff = User::whereIn('role_id', [1, 2])->latest()->get();
        return view('superadmin.staff.index', compact('staff'));
    }

    // Form tambah staff
    public function staffCreate()
    {
        return view('superadmin.staff.create');
    }

    // Simpan staff baru
    public function staffStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'nik'          => 'required|digits:16|unique:users,nik',
            'password'     => 'required|min:6|confirmed',
            'role_id'      => 'required|in:1,2',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah dipakai.',
            'nik.required'          => 'NIK wajib diisi.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama_lengkap'       => $request->nama_lengkap,
            'username'           => $request->nama_lengkap,
            'email'              => $request->email,
            'nik'                => $request->nik,
            'no_kk'             => null,
            'password'           => Hash::make($request->password),
            'role_id'            => $request->role_id,
            'status'             => 'aktif',
            'tanggal_registrasi' => now(),
        ]);

        \App\Helpers\ActivityHelper::log(
            'tambah_staff',
            'staff',
            "Menambahkan akun staff baru: {$user->nama_lengkap} ({$user->email})",
            $user->id,
            'User'
        );

        return redirect('/superadmin/staff')->with('success', 'Akun staff berhasil dibuat!');
    }

    // Form edit staff
    public function staffEdit($id)
    {
        $staff = User::whereIn('role_id', [1, 2])->findOrFail($id);
        return view('superadmin.staff.edit', compact('staff'));
    }

    // Update staff
    public function staffUpdate(Request $request, $id)
    {
        $staff = User::whereIn('role_id', [1, 2])->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email,' . $id,
            'role_id'      => 'required|in:1,2',
            'password'     => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->nama_lengkap,
            'email'        => $request->email,
            'role_id'      => $request->role_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        \App\Helpers\ActivityHelper::log(
            'edit_staff',
            'staff',
            "Mengubah data staff: {$staff->nama_lengkap}",
            $staff->id,
            'User'
        );

        return redirect('/superadmin/staff')->with('success', 'Data staff berhasil diperbarui!');
    }

    // Hapus staff
    public function staffDestroy($id)
    {
        $staff = User::whereIn('role_id', [1, 2])->findOrFail($id);

        // Tidak bisa hapus diri sendiri
        if ($staff->id == session('user_id')) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        \App\Helpers\ActivityHelper::log(
            'hapus_staff',
            'staff',
            "Menghapus akun staff: {$staff->nama_lengkap}",
            $staff->id,
            'User'
        );

        $staff->delete();

        return redirect('/superadmin/staff')->with('success', 'Akun staff berhasil dihapus!');
    }

    // History semua staff (superadmin)
    public function historyIndex(Request $request)
    {
        $userId = $request->user_id;
        $modul  = $request->modul;

        $history = ActivityLog::with('user')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($modul, fn($q) => $q->where('modul', $modul))
            ->latest()
            ->paginate(20);

        $staff = User::whereIn('role_id', [1, 2])->get();

        return view('superadmin.history.index', compact('history', 'staff', 'userId', 'modul'));
    }
}
