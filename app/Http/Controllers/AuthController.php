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

    public function login(Request $r)
    {
        $r->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $r->only('email','password');
        $remember = (bool) $r->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $r->session()->regenerate();
            $destination = Auth::user()->isAttendanceOnly()
                ? route('presences.scan')
                : route('dashboard');

            return Auth::user()->isAttendanceOnly()
                ? redirect()->route('presences.scan')->with('ok', 'Selamat datang, '.Auth::user()->name)
                : redirect()->intended($destination)->with('ok', 'Selamat datang, '.Auth::user()->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login')->with('ok', 'Anda telah logout.');
    }
}
