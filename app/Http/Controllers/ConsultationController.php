<?php
namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Product;
use App\Support\ConsultationNotifications;
use App\Services\WhatsAppService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $product = $request->filled('produk') ? Product::where('slug', $request->input('produk'))->first() : null;
        $products = Product::orderBy('name')->get(['id', 'name']);
        $token = (string) Str::uuid();
        $request->session()->put('consultation_token', $token);
        return view('consultation.index', compact('product', 'products', 'token'));
    }

    public function store(Request $request, WhatsAppService $whatsapp)
    {
        $registered = $request->user()?->role === 'client' && $request->user()->is_active;
        $rules = [
            'business_name' => 'nullable|string|max:160',
            'product_id' => 'nullable|integer|exists:products,id',
            'service_interest' => ['nullable', Rule::in(['Website Company Profile','Landing Page','Katalog Digital','Sistem Informasi','POS / Sistem Operasional','Lainnya'])],
            'service_interest_other' => 'required_if:service_interest,Lainnya|nullable|string|max:140',
            'budget' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
            'submission_token' => 'required|uuid',
        ];
        if (!$registered) {
            $rules += ['name' => 'required|string|max:120', 'phone' => 'required|string|max:40', 'email' => 'required|email|max:160'];
        }
        $data = $request->validate($rules);
        if (!hash_equals((string) $request->session()->get('consultation_token', ''), $data['submission_token'])) {
            throw ValidationException::withMessages(['message' => 'Form ini sudah digunakan atau sesi kedaluwarsa. Muat ulang halaman konsultasi.']);
        }
        if ($registered) {
            $data['name'] = $request->user()->name;
            $data['phone'] = $request->user()->phone;
            $data['email'] = $request->user()->email;
            $data['user_id'] = $request->user()->id;
        }
        if (($data['service_interest'] ?? null) === 'Lainnya') {
            $data['service_interest'] = 'Lainnya: '.trim($data['service_interest_other']);
        }
        unset($data['service_interest_other']);
        // Always resolve the product from the database, never from a client supplied name.
        $product = !empty($data['product_id']) ? Product::findOrFail($data['product_id']) : null;
        $data['product_name_snapshot'] = $product?->name;
        $data['source'] = $product ? 'website_detail_produk' : 'website_consultation';
        $data['status'] = 'new';
        try {
            $lead = Consultation::create($data);
        } catch (UniqueConstraintViolationException $exception) {
            throw ValidationException::withMessages(['message' => 'Form konsultasi sudah terkirim. Periksa riwayat akun Anda atau muat ulang halaman.']);
        }
        $lead->update(['reference_code' => 'KSL-'.str_pad((string) $lead->id, 5, '0', STR_PAD_LEFT)]);
        $request->session()->forget('consultation_token');
        ConsultationNotifications::forStaff($lead);
        try {
            $message = "Ada konsultasi baru: {$lead->reference}\n\nProduk: {$lead->product_label}\nNama: {$lead->name}\nBisnis: ".($lead->business_name ?: '-')."\nWhatsApp: {$lead->phone}\nEmail: {$lead->email}\nKebutuhan: {$lead->message}";
            $whatsapp->sendMessage($message);
        } catch (\Throwable $exception) {
            Log::warning('Lead tersimpan, notifikasi WhatsApp tidak dikirim.', ['lead_id' => $lead->id, 'error' => $exception->getMessage()]);
        }
        return redirect()->route($registered ? 'client.consultations.show' : 'consultation', $registered ? ['consultation' => $lead->id] : [])
            ->with('success', "Konsultasi berhasil dikirim. Nomor referensi: {$lead->reference}.");
    }
}
