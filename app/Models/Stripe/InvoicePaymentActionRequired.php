<?php

namespace App\Models\Stripe;

use App\Interfaces\Storageable;
use App\Interfaces\Stripe\CustomerEvent;
use App\Models\User;

class InvoicePaymentActionRequired implements CustomerEvent, Storageable {

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

    public function GetCustomerName(object $event): string
    {
        return $event->payload['data']['object']['customer_name'];
    }

    public function GetStatus(object $event): string
    {
        return $event->payload['data']['object']['status'];
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) invoice payment action required";
    }

    public function GetStoreObject(): array
    {
        return [
            'status' => null,
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

    public function GetUser(): User
    {
        return User::where('email', $this->CustomerEmail)->first();
    }

}