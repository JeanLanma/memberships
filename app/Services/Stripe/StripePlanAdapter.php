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

    public static function GetPostLimitFromSlug($StripePlanSlug): int
    {
        $PostsLimits = [
            'plan_mensual' => 1,
            'plan_semestral' => 2,
            'plan_anual' => 3,
            'plan_especial' => 1,
        ];

        return $PostsLimits[$StripePlanSlug] ?? 0;
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

    /**
     * Filters the plans to show in the view 
     * 
     * @return array
     */
    public static function GetPlanParameters(): array
    {
        return [
            'created' => ['gte' => 1693555276]
        ];
    }
}