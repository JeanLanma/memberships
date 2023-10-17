<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class GetProjobiUserService {
    
    /**
     * Get all users from the projobi database
     * 
     * @return array
     */
    
    public static function get()
    {
        return ProjobiUser::all();
    }

    public static function getUserById(int $id)
    {
        return ProjobiUser::where('id', $id)->first();
    }

    public static function getUserBySubscriptionId(string $subscriptionId)
    {
        return ProjobiUser::where('subscription_id', $subscriptionId)->first();
    }

    public function GetUserByEmail(string $email)
    {
        return ProjobiUser::where('email', $email)->first();
    }
}