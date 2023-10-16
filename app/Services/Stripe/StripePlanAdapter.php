<?php

namespace App\Services\Stripe;

class StripePlanAdapter {

    /**
     * Retrieve plan slug from Stripe Plan
     * 
     * @param Stripe\Plan{string} $StripePlan
     * @return string
     */
    public static function GetPlanSlug($StripePlan)
    {
        return array_search($StripePlan, config('projobi.stripe.plans')) ?? 'free';
    }

    /**
     * Retrive plan duration in days from Stripe Plan
     * 
     * @param string $StripePlanSlug
     * @return int
     */

    public static function GetPlanDurationFromSlug($StripePlanSlug): int
    {
        $planDurationInDays = [
            'plan_mensual' => 30,
            'plan_semestral' => 180,
            'plan_anual' => 365,
            'plan_especial' => 1,
        ];

        return $planDurationInDays[$StripePlanSlug] ?? 0;
    }

    /**
     * 
     * @param Stripe\Plan $StripePlan
     * @return object
     */
    public static function PlanMetadataAdapter($StripePlan)
    {
        return json_decode(json_encode($StripePlan->metadata));
    }

    /**
     * 
     * Filter the features of the plan to show in the view
     * @example $
     */
    public static function FilterPlanFeatures($StripePlanMetadata)
    {
        $features = [];
        foreach ($StripePlanMetadata as $key => $value) {
            if (str_starts_with($key, "feature_")) {
                $features[] = $value;
            }
        }
        return $features;
    }
}