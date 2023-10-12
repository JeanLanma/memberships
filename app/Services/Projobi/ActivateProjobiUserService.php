<?php

namespace App\Services\Projobi;

use App\Models\Projobi\ProjobiUser;
use Illuminate\Support\Facades\DB;

class ActivateProjobiUserService
{
    public static function activateUserSubscription(object $event): void
    {
        $projobiUser = ProjobiUser::where('id', $event->customer_user->projobi_user_id)->first();
        
        if ($projobiUser) {
            $projobiUser->update([
                'subscription_status' => 'active',
                'is_subscriber' => 'yes',
                'plan_slug' => $event->payload['data']['object']['plan']['id'],
                'subscription_id' => $event->payload['data']['object']['id'],
                'updated_at' => now(),
            ]);
        }
    }
}