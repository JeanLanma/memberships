<?php

namespace App\Listeners;

use App\Services\Stripe\StripeEventLogger;
use App\Services\Stripe\StripeEventService;
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
        if(StripeEventService::IsValidEvent($event))
        {
            $eventModel = StripeEventService::GetEventModel($event);
            $event->processed = $eventModel->GetDescription();
        }
        
        // Save to database
        StripeEventLogger::SaveToDatabase($event);
    }
}
