<?php

namespace App\Services\Stripe;

class StripePlanAdapter {


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