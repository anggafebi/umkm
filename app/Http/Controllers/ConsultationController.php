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
        $product = $request->filled('produk')
            ? Product::where('slug', $request->input('produk'))->first()
            : null;

        $products = Product::orderBy('name')->get(['id', 'name']);
        $token = (string) Str::uuid();
        $request->session()->put('consultation_token', $token);

        return view('consultation.index', compact('product', 'products', 'token'));
    }

    public function store(Request $request, WhatsAppService $whatsapp)
    {
        $rules = [
            'business_name' => 'nullable|string|max:160',
            'product_id' => 'nullable|integer|exists:products,id',
            'service_interest' => ['nullable', Rule::in([
                'Website Company Profile', 'Landing Page', 'Katalog Digital',
                'Sistem Informasi', 'POS / Sistem Operasional', 'Lainnya',
            ])],
            'service_interest_other' => 'required_if:service_interest,Lainnya|nullable|string|max:140',
            'budget' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
            'submission_token' => 'required|uuid',
        ];

        if ($request->user()) {
            $data = $request->validate($rules);
            $data['name'] = $request->user()->name;
            $data['email'] = $request->user()->email;
            $data['phone'] = $request->user()->phone;
            $data['user_id'] = $request->user()->id;
        } else {
            $data = $request->validate(array_merge($rules, [
                'name' => 'required|string|max:120',
                'email' => 'required|email|max:160',
                'phone' => 'required|string|max:40',
            ]));
            $data['user_id'] = null;
        }

        if (!hash_equals(
            (string) $request->session()->get('consultation_token', ''),
            $data['submission_token']
        )) {
            throw ValidationException::withMessages([
                'message' => 'Form ini sudah digunakan atau sesi kedaluwarsa. Muat ulang halaman konsultasi.',
            ]);
        }

        if (($data['service_interest'] ?? null) === 'Lainnya') {
            $data['service_interest'] = 'Lainnya: '.trim($data['service_interest_other']);
        }
        unset($data['service_interest_other']);

        $product = !empty($data['product_id'])
            ? Product::findOrFail($data['product_id'])
            : null;

        $data['product_name_snapshot'] = $product?->name;
        $data['source'] = $product ? 'website_detail_produk' : 'website_consultation';
        $data['status'] = 'new';

        try {
            $lead = Consultation::create($data);
        } catch (UniqueConstraintViolationException $exception) {
            throw ValidationException::withMessages([
                'message' => 'Form konsultasi sudah terkirim. Muat ulang halaman untuk mengirim konsultasi baru.',
            ]);
        }

        $lead->update([
            'reference_code' => 'KSL-'.str_pad((string) $lead->id, 5, '0', STR_PAD_LEFT),
        ]);

        $request->session()->forget('consultation_token');
        ConsultationNotifications::forStaff($lead);

        // Kirim WhatsApp setelah data berhasil tersimpan. Kegagalan WA tidak menghapus konsultasi.
        try {
            $response = $whatsapp->sendConsultationNotification($lead);
            if (!$response->successful()) {
                Log::warning('Konsultasi tersimpan, tetapi notifikasi WhatsApp gagal dikirim.', [
                    'lead_id' => $lead->id,
                    'http_status' => $response->status(),
                ]);
            }
        } catch (\Throwable $exception) {
            Log::warning('Konsultasi tersimpan, notifikasi WhatsApp tidak terkirim.', [
                'lead_id' => $lead->id,
                'error' => $exception->getMessage(),
            ]);
        }

        if ($request->user()) {
            return redirect()
                ->route('client.consultations.show', ['consultation' => $lead->id])
                ->with('success', "Konsultasi berhasil dikirim. Nomor referensi: {$lead->reference}.");
        }

        $pendingIds = $request->session()->get('guest_consultation_ids', []);
        $pendingIds[] = $lead->id;
        $request->session()->put('guest_consultation_ids', array_values(array_unique($pendingIds)));

        return redirect()->route('register')
            ->with('success', "Konsultasi berhasil dikirim. Nomor referensi: {$lead->reference}. Buat akun klien untuk memantau perkembangannya.");
    }
}
