<?php

namespace App\Models\Stripe;

use App\Interfaces\Stripe\CustomerSubscriptionEvent;
use App\Interfaces\Storageable;

use App\Models\Stripe\Traits\GetProjobiAttributes;
use App\Models\User;
use App\Services\Projobi\UpdateProjobiUserService;

class CustomerSubscription implements CustomerSubscriptionEvent, Storageable {

    use GetProjobiAttributes;

    public $Status;
    public $PriceID;
    public $PlanSlug;
    public $CustomerID;
    public $planDuration;
    public $_event;
    
    public function __construct(object $event)
    {
        $this->_event = $event;
        $this->Status = $this->GetStatus($event);
        $this->PriceID = $this->GetPriceID($event);
        $this->PlanSlug = $this->GetPlanSlug($event);
        $this->CustomerID = $this->GetCustomerID($event);
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

    public function GetStoreObject(): array
    {
        return [
            'subscription_status' => $this->Status,
            'is_subscriber' => ($this->Status == 'active' || $this->Status == 'trialing') ? 'yes' : 'no',
            'plan_slug' => $this->PlanSlug,
            'subscription_active_until' => now()->addDays($this->planDuration),
            'post_limit' => $this->GetPostLimit(),
            'updated_at' => now()
        ];
    }

    public function HasStoreUpdate(): bool
    {
        return true;
    }

    public function UpdateStore(): void
    {
        $user = $this->GetUser();
        if ($user) {
            UpdateProjobiUserService::UpdateSubscription($user->projobi_user_id, $this->GetStoreObject());
        }
    }

    public function GetStatus(object $event): string
    {
        return $event->payload['data']['object']['status'];
    }

    public function GetUser(): User|null
    {
        return User::where('stripe_id', $this->CustomerID)->first();
    }
}