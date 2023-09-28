<?php

function formatCurrency($amount): int|string 
{
    if (!$amount) {
        $amount = 0;
    }

    if (!is_numeric($amount)) {
        return $amount;
    }

    return (new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY))->formatCurrency(
        $amount, config("cashier.currency"),
    );
}

function getPlanNameByStripePlan(\Stripe\Plan $plan): string 
{
    if($plan->interval_count === 6) {
        return "Semestral";
    } else {
        if ($plan->interval === "year") {
            return "Anual";
        } else {
            return "Mensual";
        }
    }
}

function getSubscriptionNameForUser(): string 
{
    if (auth()->user()->subscribed()) {
        $subscription = auth()->user()->subscription();
        $key = config('cashier.secret');
        $stripe = new \Stripe\StripeClient($key);
        $plan = $stripe->plans->retrieve($subscription->stripe_price);
        return getPlanNameByStripePlan($plan);
    }
    return "N/D";
}

function isSubscribed(): bool {
    return auth()->check() && auth()->user()->subscribed();
}