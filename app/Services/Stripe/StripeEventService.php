<?php

namespace App\Services\Stripe;

use App\Models\Stripe\InvoicePaymentActionRequired;
use App\Models\Stripe\CustomerSubscriptionUpdated;
use App\Models\Stripe\InvoicePaymentSucceeded;
use App\Interfaces\Stripe\CustomerEvent;
use App\Models\Stripe\CustomerUpdated;
use App\Models\Stripe\GenericStripeEvent;

class StripeEventService {

    public static function GetEventModel(object $event): mixed
    {
        $EventModels = [
            'customer.updated' => CustomerUpdated::class,
            'customer.deleted' => CustomerUpdated::class,
            'customer.subscription.created' => CustomerSubscriptionUpdated::class,
            'customer.subscription.updated' => CustomerSubscriptionUpdated::class,
            'customer.subscription.deleted' => CustomerSubscriptionUpdated::class,
            'invoice.payment_action_required' => InvoicePaymentActionRequired::class,
            'invoice.payment_succeeded' => InvoicePaymentSucceeded::class,
        ];

        $type = $event->payload['type'];
        return array_key_exists($type, $EventModels)
            ? new $EventModels[$type]($event)
            : new GenericStripeEvent($event);
    }

    /**
     * Check if the event is valid, a valid event must have a type and a data object
     * 
     * @return bool
     */
    public static function IsValidEvent($event): bool
    {
        return isset($event->payload['type']) && isset($event->payload['data']['object']);
    }

}