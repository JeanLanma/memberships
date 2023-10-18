<?php

namespace App\Models\Stripe;

class CustomerSubscriptionUpdated extends CustomerSubscription {

    /**
     * @override
     */
    public function GetDescription(): string
    {
        return "Customer {$this->CustomerID} subscription updated, status changed to {$this->Status}";
    }

}