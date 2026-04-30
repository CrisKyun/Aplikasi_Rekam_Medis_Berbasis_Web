<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        // Kalau sudah login, langsung ke dashboard
        if (session('user_id')) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'nik'      => 'required|digits:16',
            'password' => 'required|min:6',
        ], [
            'nik.required'      => 'NIK wajib diisi.',
            'nik.digits'        => 'NIK harus 16 digit angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Cari user berdasarkan NIK
        $user = User::where('nik', $request->nik)->first();

        // Cek apakah NIK & password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nik' => 'NIK atau password salah.',
            ])->withInput();
        }

        // Simpan session
        session([
            'user_id'   => $user->id,
            'user_nama' => $user->username,
            'user_role' => $user->role_id,
            'user_nik'  => $user->nik,
            'no_kk'     => $user->no_kk,
        ]);

        return redirect('/dashboard');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
