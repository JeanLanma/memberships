<?php

namespace App\Models\Stripe;

use App\Interfaces\Storageable;
use App\Interfaces\Stripe\CustomerEvent;

class CustomerUpdated extends Customer implements CustomerEvent, Storageable {

    /**
     * @override
     */
    public function GetStoreObject(): array
    {
        return [
            'subscription_id' => $this->CustomerID,
            'updated_at' => now()
        ];
    }

    /**
     * @override
     */
    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) updated";
    }

}