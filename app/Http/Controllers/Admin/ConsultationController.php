<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Consultation;
use App\Models\Product;
use App\Models\SystemNotification;
use App\Support\ConsultationNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $consultations = Consultation::query()
            ->withCount('replies')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('product_id'), fn ($q) => $q->where('product_id', $request->product_id))
            ->when($request->filled('q'), fn ($q) => $q->where(function ($x) use ($request) {
                $search = '%'.$request->q.'%';
                $x->where('name', 'like', $search)->orWhere('business_name', 'like', $search)
                    ->orWhere('phone', 'like', $search)->orWhere('email', 'like', $search)
                    ->orWhere('message', 'like', $search)->orWhere('reference_code', 'like', $search)
                    ->orWhere('product_name_snapshot', 'like', $search);
            }))
            ->latest()->paginate(15)->withQueryString();
        $unreadReplyTicketIds = SystemNotification::where('user_id', auth()->id())
            ->where('type', 'consultation_client_reply')->whereNull('read_at')
            ->whereIn('consultation_id', $consultations->getCollection()->pluck('id'))->pluck('consultation_id')->unique()->all();
        $products = Product::orderBy('name')->get(['id', 'name']);
        $unread = SystemNotification::where('user_id', auth()->id())->whereIn('type', ['consultation_new', 'consultation_client_reply'])->whereNull('read_at')->count();
        return view('admin.consultations.index', compact('consultations', 'products', 'unread', 'unreadReplyTicketIds'));
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['replies' => fn ($query) => $query->orderBy('created_at'), 'replies.sender', 'statusLogs' => fn ($query) => $query->orderBy('created_at'), 'statusLogs.changer']);
        SystemNotification::where('user_id', auth()->id())->where('consultation_id', $consultation->id)
            ->whereIn('type', ['consultation_new', 'consultation_client_reply'])->whereNull('read_at')->update(['read_at' => now()]);
        $replyToken = (string) Str::uuid();
        request()->session()->put('admin_consultation_reply_token_'.$consultation->id, $replyToken);
        return view('admin.consultations.show', compact('consultation', 'replyToken'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $data = $request->validate(['status' => 'required|in:new,contacted,follow_up,deal,closed', 'admin_notes' => 'nullable|string|max:3000']);
        DB::transaction(function () use ($request, $consultation, $data) {
            $locked = Consultation::whereKey($consultation->id)->lockForUpdate()->firstOrFail();
            $oldStatus = $locked->status;
            if ($data['status'] !== 'new') $data['last_contacted_at'] = now();
            $locked->update($data);
            if ($oldStatus !== $data['status']) {
                $consultation->statusLogs()->create([
                    'old_status' => $oldStatus, 'new_status' => $data['status'], 'changed_by' => auth()->id(), 'created_at' => now(),
                ]);
                $labels = ['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Tindak lanjut','deal'=>'Disepakati','closed'=>'Selesai'];
                ConsultationNotifications::forOwner($consultation, 'status_changed', 'Status konsultasi diperbarui',
                    "Status konsultasi {$consultation->reference} berubah menjadi {$labels[$data['status']]}." );
            }
            ActivityLog::create(['user_id' => auth()->id(), 'action' => 'lead.updated', 'description' => "Lead {$consultation->reference} diubah ke {$data['status']}", 'ip_address' => $request->ip()]);
        });
        return back()->with('success', 'Status dan catatan konsultasi diperbarui.');
    }

    public function reply(Request $request, Consultation $consultation)
    {
        $data = $request->validate(['body' => 'required|string|max:2000', 'submission_token' => 'required|uuid']);
        $token = (string) $request->session()->get('admin_consultation_reply_token_'.$consultation->id, '');
        if (!$token || !hash_equals($token, $data['submission_token'])) {
            throw ValidationException::withMessages(['body' => 'Form balasan sudah digunakan atau kedaluwarsa. Muat ulang detail konsultasi.']);
        }
        DB::transaction(function () use ($request, $consultation, $data) {
            $locked = Consultation::whereKey($consultation->id)->lockForUpdate()->firstOrFail();
            if ($locked->status === 'closed') {
                throw ValidationException::withMessages(['body' => 'Tiket sudah selesai. Buka kembali tiket melalui status sebelum membalas.']);
            }
            $locked->replies()->create([
                'sender_user_id' => auth()->id(), 'sender_role' => auth()->user()->role,
                'body' => trim($data['body']), 'submission_token' => $data['submission_token'],
            ]);
            ConsultationNotifications::forOwner($locked, 'reply', 'Ada balasan baru', "Ada balasan baru untuk konsultasi {$locked->reference}.");
            ActivityLog::create(['user_id' => auth()->id(), 'action' => 'lead.replied', 'description' => "Membalas konsultasi {$locked->reference}", 'ip_address' => $request->ip()]);
        });
        $request->session()->forget('admin_consultation_reply_token_'.$consultation->id);
        return redirect()->route('admin.consultations.show', $consultation)->with('success', $consultation->user_id ? 'Balasan dikirim ke akun client.' : 'Balasan dicatat. Guest perlu ditindaklanjuti lewat WhatsApp/email.');
    }

    public function export()
    {
        $filename = 'leads-'.now()->format('Ymd-His').'.csv';
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Referensi', 'Nama', 'Bisnis', 'Telepon', 'Email', 'Produk', 'Minat', 'Budget', 'Status', 'Tanggal']);
            Consultation::latest()->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $r) fputcsv($out, [$r->reference, $r->name, $r->business_name, $r->phone, $r->email, $r->product_label, $r->service_interest, $r->budget, $r->status, $r->created_at]);
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
