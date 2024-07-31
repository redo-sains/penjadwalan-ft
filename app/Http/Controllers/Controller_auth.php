<?php

namespace App\Http\Controllers;

use App\Models\M_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller_auth extends Controller
{
    public function show()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        // Validasi data yang diterima dari form login
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:50',
        ]);

        // Ambil username dan password dari request
        $username = $request->input('username');
        $password = $request->input('password');

        // Lakukan pengecekan data pada tabel tb_user
        $user = M_users::where('username', $username)->first();

        // Jika user tidak ditemukan, kembalikan response error
        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        // Jika otentikasi berhasil, data pengguna akan disimpan dalam session
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Jika pengguna memiliki peran 'admin', arahkan ke halaman dashboard
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Login berhasil.');
            } else {
                return redirect()->route('dashboard-mahasiswa')->with('success', 'Login mahasiswa berhasil.');
                // Jika tidak, arahkan ke halaman yang sesuai untuk pengguna biasa
                // return redirect()->intended('beranda');

            }
        } else {
            // Jika otentikasi gagal, kembalikan pengguna ke halaman login dengan pesan error
            return back()->with('error', 'Username atau password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect ke halaman login setelah logout
        return redirect()->route('login')->with('success', 'Anda sudah log out.');
    }
}
