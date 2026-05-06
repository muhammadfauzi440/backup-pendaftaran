<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function login_form()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'user.dashboard');
        }

        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            if (Auth::user()->role === 'admin') { 
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])->withInput();
    }

    public function register_form()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan akun baru Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function forgot_password_form()
    {
        return view('auth.forgot_password');
    }

    public function forgot_password_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak ditemmukan dalam sistem kami'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
        return back()->with('success', 'Link reset password telah dikirim ke email Anda');
    }

    public function reset_password_form($token, Request $request)
    {
        return view('auth.reset_password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset_password_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $resetRecord = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->where('created_at', '>=', Carbon::now()->subMinutes(60))
        ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Token tidak valid atau sudah kadaluarsa. Silakan minta link reset password baru.');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah, silahkan login menggunakan password baru Anda');
    }
}