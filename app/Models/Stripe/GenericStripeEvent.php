<?php

namespace App\Models\Stripe;

use App\Interfaces\Descriptable;
use App\Interfaces\Storageable;

class GenericStripeEvent implements Storageable {

    public function GetDescription(): string
    {
        return "Generic Stripe Event";
    }

    public function GetStoreObject(): object|array
    {
        return (object) [
            'subscription_id' => 'generic',
            'updated_at' => now()
        ];
    }

    public function HasStoreUpdate(): bool
    {
        return false;
    }

    public function UpdateStore(): void
    {
        return;
    }
}