<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\Consultation;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (Auth::user()->role === 'client' && !Auth::user()->is_active) {
                Auth::logout();
                throw ValidationException::withMessages(['email' => 'Akun client dinonaktifkan.']);
            }
            RateLimiter::clear($key);
            $request->session()->regenerate();

            // Hubungkan konsultasi guest dari sesi ini ke akun dengan email yang sama.
            $pendingConsultationIds = $request->session()->get('guest_consultation_ids', []);
            if (Auth::user()->role === 'client' && !empty($pendingConsultationIds)) {
                Consultation::whereIn('id', $pendingConsultationIds)
                    ->whereNull('user_id')
                    ->where('email', Auth::user()->email)
                    ->update(['user_id' => Auth::id()]);
                $request->session()->forget('guest_consultation_ids');
            }

            return Auth::user()->role === 'client'
                ? redirect()->route('client.dashboard')
                : redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
