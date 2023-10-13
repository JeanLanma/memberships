<?php

namespace App\Listeners;

use App\Services\Stripe\StripeEventLogger;
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
        //ToDo Implementar integración con la plataforma
        
        
        // write a log file to local disk
        StripeEventLogger::SaveToDatabase($event);
    }
}
