<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;

class UpdateProjobiUserService {
    
    /**
     * Update a user in the projobi database if exists    
     * Data required:
     * - projobi_user_id
     * - is_subscriber
     * - subscription_id
     * - subscription_status
     * - plan_slug
     * - plan_duration
     * - updated_at
     * 
     * @param int $projobiUserId
     * @param array $updateData
     * 
     * @return array|null
     */
    
    public static function Update($projobiUserId, $updateData)
    {
        $projobiUser = ProjobiUser::where('id', $projobiUserId)->first();

        if(!$projobiUser || is_null($projobiUser)) {
            return null;
        }

        $projobiUser->update($updateData);

        return $projobiUser;
    }

    /**
     * Update the user subscription_id in the projobi database if exists and has different subscription_id
     * 
     * @param int $ProjobiUserId
     * @param string $CustomerID
     * @return bool|null
     */

    public static function CustomerUpdate($ProjobiUserId, $CustomerID)
    {
        $ProjobiUser = ProjobiUser::where('id', $ProjobiUserId)->first();

        if(!$ProjobiUser) {
            return null;
        }

        if($ProjobiUser->subscription_id == $CustomerID) {
            return null;
        }

        return $ProjobiUser->update([
            'subscription_id' => $CustomerID
        ]);
    }

    public static function UpdateSubscription($projobiUserId, $updateData)
    {
        $projobiUser = ProjobiUser::where('id', $projobiUserId)->first();

        if(!$projobiUser || is_null($projobiUser)) {
            return null;
        }

        $projobiUser->update($updateData);

        return $projobiUser;
    }

    public static function UpdateSubscriptionTrialEndsAt($projobiUserId, $trialEndsAt)
    {
        $projobiUser = ProjobiUser::where('id', $projobiUserId)->first();

        if(!$projobiUser || is_null($projobiUser)) {
            return null;
        }

        $projobiUser->update([
            'subscription_active_until' => $trialEndsAt,
            'updated_at' => now()
        ]);

        return $projobiUser;
    }
}