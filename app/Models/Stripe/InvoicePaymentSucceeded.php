<?php

namespace App\Models\Stripe;

use App\Interfaces\Storageable;
use App\Interfaces\Stripe\CustomerEvent;
use App\Models\User;
use App\Services\Stripe\StripePlanAdapter;

class InvoicePaymentSucceeded implements CustomerEvent, Storageable{

    public $status;
    public $_event;
    public $PriceID;
    public $PlanSlug;
    public $CustomerID;
    public $PlanDuration;
    public $CustomerName;
    public $CustomerEmail;

    public function __construct(object $event)
    {
        $this->_event = $event;
        $this->PriceID = $this->GetPriceId();
        $this->PlanSlug = $this->GetPlanSlug();
        $this->status = $this->GetStatus($event);
        $this->PlanDuration = $this->GetPlanDuration();
        $this->CustomerID = $this->GetCustomerID($event);
        $this->CustomerName = $this->GetCustomerName($event);
        $this->CustomerEmail = $this->GetCustomerEmail($event);
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
        return "Customer {$this->CustomerEmail} ({$this->CustomerID}) invoice payment succeeded staus changed to {$this->status}";
    }

    public function GetStoreObject(): object
    {
        return (object) [
            'plan_slug' => $this->PlanSlug,
            'is_subscriber' => $this->status == 'paid' ? 'yes' : 'no',
            'status' => $this->status == 'paid' ? 'active' : null,
            'subscription_active_until' => now()->addDays($this->PlanDuration),
            'updated_at' => now(),
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

    public function GetPriceId()
    {
        return $this->_event->payload['data']['object']['lines']['data'][0]['price']['id'];
    }

    public function GetPlanSlug(): string
    {
        return StripePlanAdapter::GetPlanSlug($this->PriceID);
    }

    public function GetPlanDuration(): int
    {
        return StripePlanAdapter::GetPlanDurationFromSlug($this->PlanSlug);
    }
}