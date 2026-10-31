<?php
namespace App\Support;

use App\Models\Consultation;
use App\Models\SystemNotification;
use App\Models\User;

class ConsultationNotifications
{
    public static function forOwner(Consultation $consultation, string $type, string $title, string $body): void
    {
        if ($consultation->user_id) {
            SystemNotification::create([
                'user_id' => $consultation->user_id,
                'consultation_id' => $consultation->id,
                'type' => $type, 'title' => $title, 'body' => $body,
            ]);
        }
    }

    public static function forStaffReply(Consultation $consultation): void
    {
        User::whereIn('role', ['admin', 'editor'])->where('is_active', true)->pluck('id')->each(
            fn ($id) => SystemNotification::create([
                'user_id' => $id, 'consultation_id' => $consultation->id,
                'type' => 'consultation_client_reply', 'title' => 'Balasan baru dari client',
                'body' => 'Client '.$consultation->name.' membalas konsultasi '.$consultation->reference.'.',
            ])
        );
    }

    public static function forStaff(Consultation $consultation): void
    {
        User::whereIn('role', ['admin', 'editor'])->where('is_active', true)->pluck('id')->each(
            fn ($id) => SystemNotification::create([
                'user_id' => $id, 'consultation_id' => $consultation->id,
                'type' => 'consultation_new', 'title' => 'Ada konsultasi baru',
                'body' => 'Ada konsultasi baru: '.($consultation->product_name_snapshot ?: 'Umum').' dari '.$consultation->name.'.',
            ])
        );
    }
}
