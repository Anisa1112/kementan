<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ✅ Redirect ke welcome (route 'home')
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau password salah!');
    }

  public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ UBAH INI - redirect ke home, bukan ke login
        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }


}
