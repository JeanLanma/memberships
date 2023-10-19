<?php

namespace App\Interfaces\Stripe;

use App\Models\User;

interface CustomerEvent {

    public function GetCustomerID(object $event): string;
    public function GetCustomerEmail(object $event): string;
    public function GetCustomerName(object $event): string;
    public function GetUser(): User|null;

}