<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    try {

        $mail = new PHPMailer(true);

        // SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME');
        $mail->Password   = env('MAIL_PASSWORD');
        $mail->Port       = env('MAIL_PORT');

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Pengirim
        $mail->setFrom(
            env('MAIL_USERNAME'),
            env('MAIL_FROM_NAME')
        );

        // Penerima
        $mail->addAddress($request->email);

        // Format Email
        $mail->isHTML(true);

        $mail->Subject = 'Reset Password Akun';

        $mail->Body = "
        <div style='font-family:Arial,sans-serif;padding:20px;'>

            <h2 style='color:#0d6efd'>
                Reset Password
            </h2>

            <p>Halo,</p>

            <p>
                Kami menerima permintaan reset password untuk akun Anda.
            </p>

            <p style='margin:30px 0;'>
                <a href='{$link}'
                   style='
                    background:#0d6efd;
                    color:white;
                    padding:12px 24px;
                    border-radius:8px;
                    text-decoration:none;
                    display:inline-block;
                    font-weight:bold;
                   '>
                    Reset Password
                </a>
            </p>

            <p style='color:#6c757d;font-size:14px;'>
                Jika Anda tidak meminta reset password,
                abaikan email ini.
            </p>

            <hr>

            <p style='font-size:13px;color:#999;'>
                Praktik Mandiri dr. Luria Widijana Haribawanti
            </p>

        </div>
        ";

        $mail->send();

        return back()->with(
            'success',
            'Link reset password berhasil dikirim ke email.'
        );

    } catch (Exception $e) {

        return back()->with(
            'error',
            'Gagal mengirim email: ' . $mail->ErrorInfo
        );

    }
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