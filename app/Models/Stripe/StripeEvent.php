<?php

namespace App\Models\Stripe;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class StripeEvent extends Model {

    protected $fillable = [
        'type',
        'payload',
        'processed_payload'
    ];

    protected $appends = [
        'customer',
        'customer_user'
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function customer(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->payload['data']['object'])['customer']
        );
    }

    public function customerUser(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->customer 
                ? User::where('stripe_id', $this->customer)->first()
                : null
        );
    }
}