<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function show() { return view('auth.register', ['remaining' => max(0, 10 - User::where('role', 'client')->count())]); }

    public function store(Request $request)
    {
        $key = 'register|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['email' => 'Terlalu banyak percobaan pendaftaran. Silakan coba lagi nanti.']);
        }
        RateLimiter::hit($key, 60);
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160|unique:users,email',
            'phone' => 'required|string|max:40',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        DB::transaction(function () use ($data) {
            // Atomic conditional UPDATE serializes concurrent registration (SQLite and MySQL).
            $taken = DB::table('client_registration_counters')->where('id', 1)->where('used', '<', 10)->increment('used');
            if ($taken !== 1) {
                throw ValidationException::withMessages(['email' => 'Pendaftaran akun sedang ditutup (maksimal 10 akun). Anda tetap dapat berkonsultasi tanpa login.']);
            }
            User::create([
                'name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'],
                'password' => Hash::make($data['password']), 'role' => 'client', 'is_active' => true,
            ]);
        }, 3);
        RateLimiter::clear($key);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }
}
