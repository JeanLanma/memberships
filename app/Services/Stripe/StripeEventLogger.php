<?php

namespace App\Services\Stripe;

use Illuminate\Support\Facades\DB;
use SplSubject;

class StripeEventLogger
{
    public static function SaveToDatabase(object $event): void
    {
        DB::table('stripe_events')->insert([
            'type' => $event->payload['type'],
            'payload' => json_encode($event->payload),
            'processed_payload' => 'processed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function ProcessPayload(object $event): string
    {
        return json_encode([
            'type' => $event->payload['type'],
            'payload' => json_encode($event->payload),
            'main_subject' => ''
        ]);
    }

    public function GetMainSubject(object $event): string
    {
        return $event->payload['type']['object']['customer'];
    }
}