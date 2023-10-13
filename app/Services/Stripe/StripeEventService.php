<?php

namespace App\Services\Stripe;

use App\Interfaces\Stripe\CustomerEvent;

use App\Models\Stripe\InvoicePaymentActionRequired;
use App\Models\Stripe\CustomerSubscriptionUpdated;
use App\Models\Stripe\CustomerUpdated;

class StripeEventService {

    public static function GetEventModel(object $event): mixed
    {
        $EventModels = [
            'customer.updated' => CustomerUpdated::class,
            'customer.subscription.created' => CustomerSubscriptionUpdated::class,
            'customer.subscription.updated' => CustomerSubscriptionUpdated::class,
            'invoice.payment_action_required' => InvoicePaymentActionRequired::class
        ];

        $type = $event->payload['type'];
        return array_key_exists($type, $EventModels)
            ? new $EventModels[$type]($event) 
            : null;
    }

}