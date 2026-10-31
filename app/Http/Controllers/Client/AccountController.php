<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\SystemNotification;
use App\Support\ConsultationNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('client.dashboard', [
            'total' => $user->consultations()->count(),
            'latest' => $user->consultations()->latest()->first(),
            'notifications' => $user->notifications()->latest()->limit(10)->get(),
            'unread' => $user->notifications()->whereNull('read_at')->count(),
        ]);
    }

    public function consultations(Request $request)
    {
        return view('client.consultations', [
            'consultations' => $request->user()->consultations()->withCount(['replies', 'replies as unread_replies_count' => fn ($query) => $query->whereIn('sender_role', ['admin','editor'])->whereNull('read_at')])->latest()->paginate(10),
        ]);
    }

    public function show(Request $request, Consultation $consultation)
    {
        abort_unless($consultation->user_id === $request->user()->id, 404);
        $consultation->load(['replies' => fn ($query) => $query->orderBy('created_at'), 'replies.sender', 'statusLogs' => fn ($query) => $query->orderBy('created_at'), 'statusLogs.changer']);
        $consultation->replies()->whereIn('sender_role', ['admin','editor'])->whereNull('read_at')->update(['read_at' => now()]);
        SystemNotification::where('user_id', $request->user()->id)->where('consultation_id', $consultation->id)
            ->whereIn('type', ['reply', 'status_changed'])->whereNull('read_at')->update(['read_at' => now()]);
        $replyToken = (string) Str::uuid();
        $request->session()->put('consultation_reply_token_'.$consultation->id, $replyToken);
        return view('client.consultation-detail', compact('consultation', 'replyToken'));
    }

    public function reply(Request $request, Consultation $consultation)
    {
        abort_unless($consultation->user_id === $request->user()->id, 404);
        $data = $request->validate([
            'body' => 'required|string|max:2000',
            'submission_token' => 'required|uuid',
        ]);
        $token = (string) $request->session()->get('consultation_reply_token_'.$consultation->id, '');
        if (!$token || !hash_equals($token, $data['submission_token'])) {
            throw ValidationException::withMessages(['body' => 'Form balasan sudah digunakan atau kedaluwarsa. Muat ulang detail konsultasi.']);
        }
        DB::transaction(function () use ($request, $consultation, $data) {
            $locked = Consultation::whereKey($consultation->id)->lockForUpdate()->firstOrFail();
            if ($locked->status === 'closed') {
                throw ValidationException::withMessages(['body' => 'Konsultasi telah selesai. Hubungi admin untuk membuka kembali tiket.']);
            }
            $locked->replies()->create([
                'sender_user_id' => $request->user()->id,
                'sender_role' => 'client',
                'body' => trim($data['body']),
                'submission_token' => $data['submission_token'],
            ]);
            ConsultationNotifications::forStaffReply($locked);
        });
        $request->session()->forget('consultation_reply_token_'.$consultation->id);
        return redirect()->route('client.consultations.show', $consultation)->with('success', 'Balasan berhasil dikirim, admin akan melihat pesan Anda.');
    }

    public function readNotification(Request $request, SystemNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 404);
        $notification->update(['read_at' => now()]);
        if ($notification->consultation_id) {
            return redirect()->route('client.consultations.show', $notification->consultation_id);
        }
        return redirect()->route('client.dashboard');
    }

    public function profile() { return view('client.profile', ['user' => auth()->user()]); }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string|max:120', 'phone' => 'required|string|max:40',
            'email' => ['required','email','max:160',Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);
        if (empty($data['password'])) unset($data['password']);
        else $data['password'] = Hash::make($data['password']);
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui. Data konsultasi lama tetap tersimpan.');
    }
}
