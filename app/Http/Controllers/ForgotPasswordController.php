<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


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
            // Jangan kasih tau email tidak ada (security best practice)
            // Supaya orang tidak bisa cek email mana yang terdaftar
            return back()->with(
                'success',
                'Jika email terdaftar, link reset akan dikirim.'
            );
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => $token,
                'created_at' => now()
            ]
        );

        $link      = url('/reset-password/' . $token);
        $errorInfo = 'Unknown error';

        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->Port       = env('MAIL_PORT');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Akun';
            $mail->Body    = "
        <div style='font-family:Arial,sans-serif;padding:20px;max-width:500px;'>
            <h2 style='color:#2563eb;'>Reset Password</h2>
            <p>Halo <strong>{$user->username}</strong>,</p>
            <p>Kami menerima permintaan reset password untuk akun Anda.</p>
            <p style='margin:24px 0;'>
                <a href='{$link}'
                   style='background:#2563eb;color:white;padding:12px 24px;
                          border-radius:8px;text-decoration:none;
                          display:inline-block;font-weight:bold;'>
                    Reset Password Sekarang
                </a>
            </p>
            <p style='color:#64748b;font-size:13px;'>
                Link ini berlaku selama <strong>60 menit</strong>.
                Jika Anda tidak meminta reset password, abaikan email ini.
            </p>
            <hr style='border:none;border-top:1px solid #e2e8f0;margin:16px 0;'>
            <p style='font-size:12px;color:#94a3b8;'>
                " . (env('MAIL_FROM_NAME') ?? 'Klinik') . "
            </p>
        </div>
        ";

            $mail->send();

            return back()->with(
                'success',
                'Link reset password berhasil dikirim ke email Anda.'
            );
        } catch (Exception $e) {
            // $mail sudah pasti terdefinisi karena Exception dari PHPMailer
            // tapi kita pakai $e->getMessage() sebagai fallback yang lebih aman
            $errorInfo = isset($mail) ? $mail->ErrorInfo : $e->getMessage();

            // Log error untuk debugging (tidak ditampilkan ke user)
            Log::error('Gagal kirim email reset password: ' . $errorInfo);

            return back()->with(
                'error',
                'Gagal mengirim email. Silakan coba beberapa saat lagi.'
            );
        }
    }

    public function showResetForm($token)
    {
        $data = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$data) {
            return redirect('/login')->with('error', 'Token tidak valid.');
        }

        // Cek apakah token sudah expired (60 menit)
        if (\Carbon\Carbon::parse($data->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            return redirect('/login')->with('error', 'Token sudah kadaluarsa. Silakan minta ulang.');
        }

        return view('auth.reset_password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$data) {
            return redirect('/login')->with('error', 'Token tidak valid.');
        }

        // cek expiry di sini juga (sama seperti showResetForm)
        if (\Carbon\Carbon::parse($data->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();
            return redirect('/login')->with('error', 'Token sudah kadaluarsa.');
        }

        $user = User::where('email', $data->email)->first();

        // Guard jika email di token tidak cocok dengan user manapun
        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $data->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset.');
    }
}
