<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ClientOrder;
use App\Models\Consultation;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function show() { return view('auth.register'); }

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
        $user = User::create([
            'name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'],
            'password' => Hash::make($data['password']), 'role' => 'client', 'is_active' => true,
        ]);
        $pendingOrderIds = session('guest_order_ids', []);
        if (!empty($pendingOrderIds)) {
            ClientOrder::whereIn('id', $pendingOrderIds)
                ->whereNull('user_id')
                ->where('guest_email', $user->email)
                ->update(['user_id' => $user->id]);
            session()->forget('guest_order_ids');
        }

        $pendingConsultationIds = session('guest_consultation_ids', []);
        if (!empty($pendingConsultationIds)) {
            Consultation::whereIn('id', $pendingConsultationIds)
                ->whereNull('user_id')
                ->where('email', $user->email)
                ->update(['user_id' => $user->id]);
            session()->forget('guest_consultation_ids');
        }
        RateLimiter::clear($key);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan masuk untuk melihat konsultasi dan pengajuan Anda.');
    }
}
