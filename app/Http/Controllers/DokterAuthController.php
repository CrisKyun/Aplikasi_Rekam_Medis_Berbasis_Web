<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DokterAuthController extends Controller
{
    public function showLogin()
    {
        if (session('user_id') && session('user_role') == 1) {
            return redirect('/dokter/dashboard');
        }
        return view('dokter.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cari user dengan role superadmin atau staff
        $user = User::where('email', $request->email)
            ->whereIn('role_id', [1, 2])
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        session([
            'user_id'        => $user->id,
            'user_nama'      => $user->nama_lengkap ?? $user->username,
            'user_role'      => $user->role_id,
            'user_role_nama' => $user->role_id == 1 ? 'Superadmin' : 'Staff',
        ]);

        // Catat aktivitas login
        \App\Helpers\ActivityHelper::log(
            'login',
            'auth',
            ($user->role_id == 1 ? 'Superadmin' : 'Staff') . ' login ke sistem'
        );

        return redirect('/dokter/dashboard');
    }

    public function logout()
    {
        \App\Helpers\ActivityHelper::log('logout', 'auth', 'Logout dari sistem');

        session()->flush();
        return redirect('/dokter/login')->with('success', 'Berhasil logout.');
    }
}
