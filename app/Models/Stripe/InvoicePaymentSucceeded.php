<?php

namespace App\Models\Stripe;

use App\Interfaces\Descriptable;
use App\Interfaces\Stripe\CustomerEvent;

class InvoicePaymentSucceeded implements CustomerEvent, Descriptable{

    public $CustomerID;
    public $CustomerEmail;
    public $status;

    public function __construct(object $event)
    {
        $this->CustomerID = $this->GetCustomerID($event);
        $this->CustomerEmail = $this->GetCustomerEmail($event);
        $this->status = $this->GetStatus($event);
    }

    public function GetCustomerID(object $event): string
    {
        return $event->payload['data']['object']['customer'];
    }

    public function GetCustomerEmail(object $event): string
    {
        return $event->payload['data']['object']['customer_email'];
    }

    public function GetStatus(object $event): string
    {
        return $event->payload['data']['object']['status'];
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) invoice payment succeeded";
    }

}