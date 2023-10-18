<?php

namespace App\Enums\Stripe;

enum StripeEvent: string {

    /**
     * Posibles eventos de Stripe:
     * customer.updated
     * customer.deleted
     * customer.subscription.created
     * customer.subscription.deleted
     * customer.subscription.updated
     * invoice.payment_action_required
     * invoice.payment_succeeded
     * payment_method.automatically_updated
    */

    case CustomerUpdated = 'customer.updated';
    case CustomerDeleted = 'customer.deleted';
    case CustomerSubscriptionCreated = 'customer.subscription.created';
    case CustomerSubscriptionDeleted = 'customer.subscription.deleted';
    case CustomerSubscriptionUpdated = 'customer.subscription.updated';
    case InvoicePaymentActionRequired = 'invoice.payment_action_required';
    case InvoicePaymentSucceeded = 'invoice.payment_succeeded';
    case PaymentMethodAutomaticallyUpdated = 'payment_method.automatically_updated';

    public function status(): string
    {
        return match ($this->value) {
            self::CustomerUpdated => 'info',
            self::CustomerDeleted => 'info',
            self::CustomerSubscriptionCreated => 'success',
            self::CustomerSubscriptionDeleted => 'info',
            self::CustomerSubscriptionUpdated => 'info',
            self::InvoicePaymentActionRequired => 'warning',
            self::InvoicePaymentSucceeded => 'success',
            self::PaymentMethodAutomaticallyUpdated => 'info',
        };
    }

    public static function getValueFromPayload(\App\Models\Stripe\StripeEvent $payload): string
    {
        return $payload['type'];
    }

    public static function EventIs(\App\Models\Stripe\StripeEvent $payload, StripeEvent $stripeEvent): bool
    {
        return self::getValueFromPayload($payload) == $stripeEvent->value;
    }
}