<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan ini di-use

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses upaya login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi pengguna
        if (Auth::attempt($credentials, $request->boolean('remember'))) { // Tambah $request->boolean('remember') untuk fitur "Ingat Saya"
            $request->session()->regenerate(); // Regenerasi session ID untuk keamanan

            return redirect()->intended('/pegawai'); // Redirect ke halaman setelah login berhasil (misal /pegawai)
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email'); // Tetap simpan input email
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna

        $request->session()->invalidate(); // Batalkan session
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/'); // Redirect ke halaman utama atau halaman login
    }
}