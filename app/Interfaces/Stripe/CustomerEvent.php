<?php

namespace App\Interfaces\Stripe;

interface CustomerEvent {

    public function GetCustomerID(object $event): string;
    public function GetCustomerEmail(object $event): string;
    

}