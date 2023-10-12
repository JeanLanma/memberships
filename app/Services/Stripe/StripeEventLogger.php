<?php

namespace App\Services\Stripe;

use Illuminate\Support\Facades\DB;

class StripeEventLogger
{
    public static function SaveToDatabase(object $event): void
    {
        $eventType = $event->payload['type'];
        $event->payload['action'] = 'something';
        // write a log file to local disk
        DB::table('stripe_events')->insert([
            'type' => $eventType,
            'payload' => json_encode($event->payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}