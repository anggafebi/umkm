<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class WhatsAppService
{
    public function sendMessage(string $message): Response
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');
        $recipient = config('services.whatsapp.number');
        $version = config('services.whatsapp.graph_version', 'v20.0');

        if (!$token || !$phoneId || !$recipient) {
            throw new RuntimeException('WhatsApp API configuration is incomplete.');
        }

        $response = Http::withToken($token)
            ->timeout(10)
            ->retry(2, 300, throw: false)
            ->post("https://graph.facebook.com/{$version}/{$phoneId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $recipient,
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

        if (!$response->successful()) {
            Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
        }

        return $response;
    }
}
