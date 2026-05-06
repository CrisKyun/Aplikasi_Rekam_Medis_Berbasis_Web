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

        $user = User::where('nik', $request->nik)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nik' => 'NIK atau password salah.',
            ])->withInput();
        }

        // Cek status akun
        if ($user->status === 'nonaktif') {
            return back()->withErrors([
                'nik' => 'Akun Anda nonaktif. Silakan hubungi klinik untuk mengaktifkan kembali.',
            ])->withInput();
        }

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

    // Tampilkan halaman registrasi
    public function showRegister()
    {
        if (session('user_id')) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nik'                  => 'required|digits:16|unique:users,nik',
            'no_kk'                => 'required|digits:16',
            'username'             => 'required|string|max:50',
            'password'             => 'required|min:6|confirmed',
            'nik_pasien'           => 'required|digits:16|unique:pasien,nik',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|in:L,P',
        ], [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'no_kk.required'        => 'No. KK wajib diisi.',
            'no_kk.digits'          => 'No. KK harus 16 digit.',
            'username.required'     => 'Nama lengkap wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'nik_pasien.required'   => 'NIK pasien wajib diisi.',
            'nik_pasien.digits'     => 'NIK pasien harus 16 digit.',
            'nik_pasien.unique'     => 'NIK pasien sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
        ]);

        // Buat akun user
        $user = User::create([
            'nik'                => $request->nik,
            'no_kk'             => $request->no_kk,
            'username'          => $request->username,
            'password'          => Hash::make($request->password),
            'email'             => $request->email,
            'role_id'           => 2,
            'tanggal_registrasi' => now(),
        ]);

        // Otomatis daftarkan sebagai Kepala Keluarga
        \App\Models\Pasien::create([
            'user_id'         => $user->id,
            'nik'             => $request->nik_pasien,
            'nama_lengkap'    => $request->username,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'status_hubungan' => 'Kepala Keluarga',
            'golongan_darah'  => '-',
            'tanggal_daftar'  => now(),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
