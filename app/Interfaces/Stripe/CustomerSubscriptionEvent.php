<?php

namespace App\Interfaces\Stripe;

interface CustomerSubscriptionEvent {

    public function GetCustomerID(object $event): string;
    public function GetPriceID(object $event): string;
    public function GetStatus(object $event): string;
    public function GetPlanDuration(): int;
    public function GetPlanSlug(): string;

}