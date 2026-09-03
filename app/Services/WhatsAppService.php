<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function sendMessage($message)
    {
        $response = Http::withToken(env('WHATSAPP_TOKEN'))
            ->post(
                'https://graph.facebook.com/v20.0/' . env('WHATSAPP_PHONE_ID') . '/messages',
                [
                    'messaging_product' => 'whatsapp',
                    'to' => env('WHATSAPP_NUMBER'),
                    'type' => 'text',
                    'text' => [
                        'body' => $message
                    ]
                ]
            );

        if (!$response->successful()) {
            Log::error('WhatsApp API Error', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
        }

        return $response;
    }
}
