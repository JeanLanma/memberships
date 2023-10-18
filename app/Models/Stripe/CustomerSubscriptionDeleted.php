<?php

namespace App\Models\Stripe;

class CustomerSubscriptionDeleted extends CustomerSubscription {

    /**
     * @override
     */
    public function GetDescription(): string
    {
        return "Customer {$this->CustomerID} subscription deleted, status changed to {$this->Status}";
    }

}