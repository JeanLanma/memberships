<?php

namespace App\Models\Stripe;

class CustomerDeleted extends Customer {

    /**
     * @override
     */
    public function GetStoreObject(): array
    {
        return [
            'subscription_id' => null,
            'updated_at' => now()
        ];
    }

    /**
     * @override
     */
    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) deleted";
    }

}