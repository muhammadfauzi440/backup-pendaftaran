<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_form()
    {
        if (Auth::check()) {
            return view('auth.confirm_login');
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
}