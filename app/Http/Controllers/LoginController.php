<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        // Kalau sudah login, redirect sesuai role
        if (session('user_id')) {
            return $this->redirectByRole(session('user_role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'kredensial' => 'required|string',
            'password'   => 'required|min:6',
        ], [
            'kredensial.required' => 'NIK atau Email wajib diisi.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 6 karakter.',
        ]);

        $kredensial = $request->kredensial;

        // Deteksi: apakah input berupa email atau NIK
        $isEmail = filter_var($kredensial, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            // Login staff/dokter/admin/superadmin pakai email
            $user = User::where('email', $kredensial)
                ->whereIn('role_id', [1, 2, 3])
                ->first();
        } else {
            // Login pasien pakai NIK
            $user = User::where('nik', $kredensial)
                ->where('role_id', 4)
                ->first();
        }

        // Cek user & password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'kredensial' => $isEmail
                    ? 'Email atau password salah.'
                    : 'NIK atau password salah.',
            ])->withInput();
        }

        // Cek status akun
        if ($user->status === 'nonaktif') {
            return back()->withErrors([
                'kredensial' => 'Akun Anda nonaktif. Silakan hubungi klinik.',
            ])->withInput();
        }

        // Label role
        $roleNama = match ($user->role_id) {
            1       => 'Superadmin',
            2       => 'Admin',
            3       => 'Dokter',
            4       => 'Pasien',
            default => 'User',
        };

        // Simpan session
        session([
            'user_id'        => $user->id,
            'user_nama'      => $user->nama_lengkap ?? $user->username,
            'user_role'      => $user->role_id,
            'user_role_nama' => $roleNama,
            'user_nik'       => $user->nik,
            'no_kk'          => $user->no_kk,
        ]);

        // Log aktivitas (hanya untuk staff)
        if ($user->role_id != 4) {
            \App\Helpers\ActivityHelper::log(
                'login',
                'auth',
                "{$roleNama} login ke sistem"
            );
        }

        return $this->redirectByRole($user->role_id);
    }

    private function redirectByRole($roleId)
    {
        return match ($roleId) {
            1, 2, 3 => redirect('/dokter/dashboard'),
            4       => redirect('/dashboard'),
            default => redirect('/'),
        };
    }
}
