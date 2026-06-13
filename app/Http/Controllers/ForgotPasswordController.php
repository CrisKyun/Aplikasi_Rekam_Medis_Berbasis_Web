<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $link = url('/reset-password/' . $token);

        Mail::html("
    <div style='font-family: Arial, sans-serif; padding:20px;'>

        <h2 style='color:#0d6efd;'>
            Reset Password
        </h2>

        <p>
            Halo,
        </p>

        <p>
            Kami menerima permintaan reset password untuk akun Anda.
        </p>

        <p style='margin:30px 0;'>
            <a href='{$link}'
            style='
                    background:#0d6efd;
                    color:white;
                    padding:12px 24px;
                    text-decoration:none;
                    border-radius:8px;
                    display:inline-block;
                    font-weight:bold;
            '>
                Reset Password
            </a>
        </p>

        <p style='color:#6c757d; font-size:14px;'>
            Jika Anda tidak meminta reset password,
            abaikan email ini.
        </p>

        <hr>

        <p style='font-size:13px; color:#999;'>
            Praktik Mandiri dr. Luria Widijana Haribawanti.
        </p>

    </div>
", function ($message) use ($request) {

            $message->to($request->email)
                ->subject('Reset Password Akun');
        });

        return back()->with(
            'success',
            'Link reset password berhasil dikirim ke email.'
        );
    }

    public function showResetForm($token)
    {
        $data = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$data) {
            return redirect('/login')
                ->with('error', 'Token tidak valid.');
        }

        return view('auth.reset_password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$data) {
            return redirect('/login')
                ->with('error', 'Token tidak valid.');
        }

        $user = User::where('email', $data->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $data->email)
            ->delete();

        return redirect('/login')
            ->with('success', 'Password berhasil direset.');
    }
}
