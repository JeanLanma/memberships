<?php

namespace App\Models\Stripe;

use App\Interfaces\Descriptable;

class GenericStripeEvent implements Descriptable {

    public function GetDescription(): string
    {
        return "Generic Stripe Event";
    }

}