<?php

namespace App\Services\Stripe;

use Illuminate\Support\Facades\DB;

class StripeEventLogger
{
    public static function SaveToDatabase(object $event): void
    {
        DB::table('stripe_events')->insert([
            'type' => $event->payload['type'],
            'payload' => json_encode($event->payload),
            'processed_payload' => isset($event->processed) ? $event->processed: 'processed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}