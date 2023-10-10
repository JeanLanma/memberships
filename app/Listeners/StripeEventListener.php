<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $eventType = $event->payload['type'];

        //ToDo Implementar integración con la plataforma
        
        // write a log file to local disk
        DB::table('logs')->insert([
            'type' => $eventType,
            'payload' => json_encode($event->payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
