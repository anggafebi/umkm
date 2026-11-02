<?php

namespace App\Services;

use App\Models\Consultation;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class WhatsAppService
{
    /**
     * Notifikasi saat client membuat konsultasi baru.
     * Driver dipilih melalui WHATSAPP_DRIVER (wakita atau cloud).
     */
    public function sendConsultationNotification(Consultation $consultation): Response
    {
        if (config('services.whatsapp.driver', 'wakita') === 'wakita') {
            return $this->sendWakitaText(
                (string) config('services.wakita.admin_number'),
                $this->buildNewConsultationMessage($consultation)
            );
        }

        return $this->sendCloudTemplate(
            $consultation,
            (string) config('services.whatsapp.template_name'),
            (string) $consultation->message,
            'konsultasi baru'
        );
    }

    /**
     * Notifikasi saat client membalas tiket konsultasi.
     */
    public function sendClientReplyNotification(Consultation $consultation, string $message): Response
    {
        if (config('services.whatsapp.driver', 'wakita') === 'wakita') {
            $text = implode("\n", [
                "💬 *BALASAN KONSULTASI BARU*",
                "",
                "Client: {$consultation->name}",
                "Referensi: {$consultation->reference}",
                "Produk: {$consultation->product_label}",
                "",
                "Pesan client:",
                trim($message),
                "",
                "Silakan periksa dashboard admin untuk menanggapi.",
            ]);

            return $this->sendWakitaText(
                (string) config('services.wakita.admin_number'),
                $text
            );
        }

        $templateName = config('services.whatsapp.reply_template_name');
        if (!$templateName) {
            throw new RuntimeException(
                'WHATSAPP_REPLY_TEMPLATE_NAME belum diatur untuk WhatsApp Cloud API.'
            );
        }

        return $this->sendCloudTemplate(
            $consultation,
            (string) $templateName,
            $message,
            'balasan client'
        );
    }

    /**
     * Mengirim pesan teks melalui WaKita REST API.
     * Endpoint dan field mengikuti dokumentasi WaKita v1.4.3:
     * POST /api/v1/send, JSON: number, message.
     */
    public function sendWakitaText(string $number, string $message): Response
    {
        $baseUrl = rtrim((string) config('services.wakita.base_url'), '/');
        $apiKey = (string) config('services.wakita.api_key');
        $number = preg_replace('/\D+/', '', $number) ?? '';

        if ($baseUrl === '' || $apiKey === '' || $number === '') {
            throw new RuntimeException(
                'Konfigurasi WaKita belum lengkap. Periksa WAKITA_BASE_URL, WAKITA_API_KEY, dan WAKITA_ADMIN_NUMBER.'
            );
        }

        $response = Http::acceptJson()
            ->withHeaders(['X-API-Key' => $apiKey])
            ->timeout(20)
            ->post($baseUrl . '/send', [
                'number' => $number,
                'message' => $message,
            ]);

        if (!$response->successful() || !($response->json('success') ?? false)) {
            Log::warning('WaKita gagal mengirim pesan WhatsApp.', [
                'http_status' => $response->status(),
                'error' => $response->json('error'),
                'message' => $response->json('message'),
                'to' => $number,
            ]);
        }

        return $response;
    }

    private function buildNewConsultationMessage(Consultation $consultation): string
    {
        $lines = [
            '🔔 *PEMBERITAHUAN KONSULTASI BARU*',
            '',
            'Ada client baru yang mengirimkan konsultasi melalui website UMKM.',
            '',
            '👤 Nama: ' . $consultation->name,
        ];

        if ($consultation->business_name) {
            $lines[] = '🏢 Nama usaha: ' . $consultation->business_name;
        }

        if ($consultation->email) {
            $lines[] = '📧 Email: ' . $consultation->email;
        }

        if ($consultation->phone) {
            $lines[] = '📱 Nomor HP: ' . $consultation->phone;
        }

        $lines[] = '📦 Produk: ' . $consultation->product_label;

        if ($consultation->service_interest) {
            $lines[] = '🛠️ Minat layanan: ' . $consultation->service_interest;
        }

        if ($consultation->budget) {
            $lines[] = '💰 Anggaran: ' . $consultation->budget;
        }

        $lines[] = '';
        $lines[] = '📝 Keperluan konsultasi:';
        $lines[] = mb_substr(trim((string) $consultation->message), 0, 2500);
        $lines[] = '';
        $lines[] = '🔑 Kode Konsultasi: ' . $consultation->reference;
        $lines[] = '';
        $lines[] = 'Silakan segera periksa dashboard admin untuk menanggapi konsultasi ini.';
        $lines[] = 'Terima kasih.';

        return implode("\n", $lines);
    }

    /**
     * Integrasi WhatsApp Cloud API lama tetap tersedia jika driver=cloud.
     */
    private function sendCloudTemplate(
        Consultation $consultation,
        string $templateName,
        string $message,
        string $event
    ): Response {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');
        $recipient = config('services.whatsapp.number');
        $language = config('services.whatsapp.template_language', 'id');
        $version = config('services.whatsapp.graph_version', 'v20.0');

        if (!$token || !$phoneId || !$recipient) {
            throw new RuntimeException(
                'Konfigurasi WhatsApp Cloud API belum lengkap. Periksa WHATSAPP_PHONE_ID, WHATSAPP_TOKEN, dan WHATSAPP_NUMBER.'
            );
        }

        if (!$templateName) {
            throw new RuntimeException('Nama template WhatsApp belum diatur di file .env.');
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $recipient,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => $language],
                'components' => [[
                    'type' => 'body',
                    'parameters' => [
                        ['type' => 'text', 'text' => $consultation->reference],
                        ['type' => 'text', 'text' => $consultation->name],
                        ['type' => 'text', 'text' => $consultation->product_label],
                        ['type' => 'text', 'text' => mb_substr(trim($message), 0, 900)],
                    ],
                ]],
            ],
        ];

        $response = Http::withToken($token)
            ->timeout(15)
            ->retry(2, 500, throw: false)
            ->post("https://graph.facebook.com/{$version}/{$phoneId}/messages", $payload);

        if (!$response->successful()) {
            Log::error("WhatsApp Cloud API gagal mengirim notifikasi {$event}.", [
                'consultation_id' => $consultation->id,
                'event' => $event,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
        }

        return $response;
    }
}
