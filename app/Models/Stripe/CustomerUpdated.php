<?php

namespace App\Models\Stripe;

use App\Interfaces\Storageable;
use App\Interfaces\Stripe\CustomerEvent;
use App\Models\Stripe\Traits\GetProjobiAttributes;
use App\Models\User;

class CustomerUpdated implements CustomerEvent, Storageable {

    use GetProjobiAttributes;

    public $CustomerID;
    public $CustomerEmail;
    public $CustomerName;
    private $_event;

    public function __construct(object $event)
    {
        $this->_event = $event;
        $this->CustomerID = $this->GetCustomerID($this->_event);
        $this->CustomerName = $this->GetCustomerName($this->_event);
        $this->CustomerEmail = $this->GetCustomerEmail($this->_event);
    }

    public function GetCustomerID(object $event): string
    {
        return $event->payload['data']['object']['id'];
    }

    public function GetCustomerEmail(object $event): string
    {
        return $event->payload['data']['object']['email'];
    }

    public function GetCustomerName(object $event): string
    {
        return $event->payload['data']['object']['name'];
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) updated";
    }

    public function GetStoreObject(): array
    {
        return [
            'subscription_id' => $this->CustomerID,
            'updated_at' => now()
        ];
    }

    public function GetUser(): User
    {
        return User::where('email', $this->CustomerEmail)->first();
    }

}