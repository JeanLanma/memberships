<?php

namespace App\Models\Stripe;

use App\Interfaces\Storageable;
use App\Interfaces\Stripe\CustomerEvent;

class CustomerUpdated implements CustomerEvent, Storageable {

    public $CustomerID;
    public $CustomerEmail;

    public function __construct(object $event)
    {
        $this->CustomerID = $this->GetCustomerID($event);
        $this->CustomerEmail = $this->GetCustomerEmail($event);
    }

    public function GetCustomerID(object $event): string
    {
        return $event->payload['data']['object']['id'];
    }

    public function GetCustomerEmail(object $event): string
    {
        return $event->payload['data']['object']['email'];
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) updated";
    }

    public function GetStoreObject(object $event): object
    {
        return (object) [
            'subscription_id' => $this->CustomerID,
        ];
    }

}