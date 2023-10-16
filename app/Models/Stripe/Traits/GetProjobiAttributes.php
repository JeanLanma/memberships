<?php

namespace App\Models\Stripe\Traits;

use App\Services\Stripe\StripePlanAdapter;

trait GetProjobiAttributes {

    public function GetPlanSlug(): string
    {
        return StripePlanAdapter::GetPlanSlug($this->PriceID);
    }

    public function GetPlanDuration(): int
    {
        return StripePlanAdapter::GetPlanDurationFromSlug($this->PlanSlug);
    }

    public function GetStatus(object $event): string
    {
        return $event->payload['data']['object']['status'];
    }

}