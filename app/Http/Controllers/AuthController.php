<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil user
        $user = User::where('email', $request->email)->first();

        // Validasi user & password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        // Simpan email jika pilih ingat saya
        if ($request->remember) {
            cookie()->queue(cookie('remember_email', $request->email, 60 * 24 * 30)); // 30 hari
        } else {
            cookie()->queue(cookie()->forget('remember_email'));
        }

        // Login dengan remember token
        Auth::login($user, $request->remember ? true : false);

        return redirect('/dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        // Hapus remember token di DB
        $user = Auth::user();
        if ($user) {
            $user->setRememberToken(null);
            $user->save();
        }

        Auth::logout();

        // Hapus cookie email
        cookie()->queue(cookie()->forget('remember_email'));

        // Reset session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout!');
    }
}
