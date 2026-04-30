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
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $user = User::where('email', $request->email)
            ->where('role_id', 1)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        session([
            'user_id'   => $user->id,
            'user_nama' => $user->username,
            'user_role' => $user->role_id,
        ]);

        return redirect('/dokter/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/dokter/login')->with('success', 'Berhasil logout.');
    }
}
