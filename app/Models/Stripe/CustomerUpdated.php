<?php

namespace App\Models\Stripe;

use App\Interfaces\Descriptable;
use App\Interfaces\Stripe\CustomerEvent;

class CustomerUpdated implements CustomerEvent, Descriptable {

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

}