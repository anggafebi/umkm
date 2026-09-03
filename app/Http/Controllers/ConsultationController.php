<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class ConsultationController extends Controller
{
    public function store(Request $request, WhatsAppService $whatsapp)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $message = "Ada konsultasi baru:\n\n" .
            "Nama: {$request->name}\n" .
            "WhatsApp: {$request->phone}\n" .
            "Email: {$request->email}\n" .
            "Kebutuhan: {$request->message}";

        $response = $whatsapp->sendMessage($message);

        if (!$response->successful()) {
            return back()->with('error', 'Pesan WhatsApp gagal dikirim. Periksa konfigurasi API.');
        }

        return back()->with('success', 'Konsultasi berhasil dikirim.');
    }
}
