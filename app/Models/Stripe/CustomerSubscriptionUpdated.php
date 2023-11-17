<?php

namespace App\Models\Stripe;

class CustomerSubscriptionUpdated extends CustomerSubscription {

    /**
     * @override
     */
    public function GetDescription(): string
    {
        return "Customer {$this->CustomerID} subscription updated, status changed to {$this->Status}";
    }

    /**
     * @override
     */
    public function GetStoreObject(): array
    {
        return [
            'subscription_status' => $this->Status,
            'is_subscriber' => ($this->Status == 'active' || $this->Status == 'trialing') ? 'yes' : 'no',
            'plan_slug' => $this->PlanSlug,
            'subscription_active_until' => $this->updateActiveUntil(),
            'post_limit' => $this->GetPostLimit(),
            'updated_at' => now()
        ];
    }

    public function isTrialingUpdate(): bool
    {
        return $this->Status == 'trialing';
    }

    public function updateActiveUntil(): string
    {
        $user = $this->getUser();
        if($this->isTrialingUpdate() && !is_null($user)) {
            return $user->subscription('default')->trial_ends_at ?? now()->addDays($this->planDuration);
        }
        return now()->addDays($this->planDuration);
    }

}