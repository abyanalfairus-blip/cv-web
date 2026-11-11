<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Login dan logout panel admin.
 * Akun admin disimpan di tabel `users` (dibuat oleh AdminSeeder).
 */
class AuthController extends Controller
{
    public function form(): View|RedirectResponse
    {
        return Auth::check() ? redirect()->route('admin.dashboard') : view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $kredensial = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($kredensial, $request->boolean('ingat'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('pesan', 'Anda sudah keluar.');
    }
}
