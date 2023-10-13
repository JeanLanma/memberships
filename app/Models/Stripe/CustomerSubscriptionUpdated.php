<?php

namespace App\Models\Stripe;

use App\Interfaces\Descriptable;
use App\Interfaces\Stripe\CustomerSubscriptionEvent;
use App\Services\Stripe\StripePlanAdapter;

class CustomerSubscriptionUpdated implements CustomerSubscriptionEvent, Descriptable {

    public $CustomerID;
    public $Status;
    public $PriceID;
    public $PlanSlug;

    public function __construct(object $event)
    {
        $this->CustomerID = $this->GetCustomerID($event);
        $this->Status = $this->GetStatus($event);
        $this->PriceID = $this->GetPriceID($event);
        $this->PlanSlug = $this->GetPlanSlug($event);
    }

    public function GetCustomerID(object $event): string
    {
        return $event->payload['data']['object']['customer'];
    }

    public function GetPriceID(object $event): string
    {
        return $event->payload['data']['object']['plan']['id'];
    }

    public function GetStatus(object $event): string
    {
        return $event->payload['data']['object']['status'];
    }

    public function GetPlanSlug(object $event): string
    {
        return StripePlanAdapter::GetPlanSlug($this->PriceID);
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerID} subscription status changed to {$this->Status}";
    }
}