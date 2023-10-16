<?php

namespace App\Models\Stripe;

use App\Interfaces\Stripe\CustomerSubscriptionEvent;
use App\Models\Projobi\ProjobiUser;
use App\Interfaces\Storageable;

use App\Models\Stripe\Traits\GetProjobiAttributes;

class CustomerSubscriptionUpdated implements CustomerSubscriptionEvent, Storageable {

    use GetProjobiAttributes;

    public $CustomerID;
    public $Status;
    public $PriceID;
    public $PlanSlug;
    public $planDuration;

    public function __construct(object $event)
    {
        $this->CustomerID = $this->GetCustomerID($event);
        $this->Status = $this->GetStatus($event);
        $this->PriceID = $this->GetPriceID($event);
        $this->PlanSlug = $this->GetPlanSlug($event);
        $this->planDuration = $this->GetPlanDuration($event);
    }

    public function GetCustomerID(object $event): string
    {
        return $event->payload['data']['object']['customer'];
    }

    public function GetPriceID(object $event): string
    {
        return $event->payload['data']['object']['plan']['id'];
    }

    public function GetDescription(): string
    {
        return "Customer {$this->CustomerID} subscription status changed to {$this->Status}";
    }

    public function GetStoreObject(object $event): object
    {
        return (object) [
            'subscription_id' => $this->CustomerID,
            'status' => $this->Status,
            'is_subscriber' => $this->Status == 'active' ? 'yes' : 'no',
            'plan_slug' => $this->PlanSlug
        ];
        return ProjobiUser::where('id', $event->customer_user->projobi_user_id)->first();
    }
}