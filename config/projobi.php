<?php

return [
    /**
     * The route to projobi's home page.
     */

    'projobi_home' => env('PROJOBI_URL', '/'),

    /**
     * Page to redirect to after logout
     */
    'logout_redirect' => env('PROJOBI_URL', '/') . 'dashboard/',

    /**
     * Stripe
     */
    'stripe' => [
        'plans' => [
            'plan_mensual' => env('STRIPE_PLAN_MENSUAL'),
            'plan_semestral' => env('STRIPE_PLAN_SEMESTRAL'),
            'plan_anual' => env('STRIPE_PLAN_ANUAL'),
            'plan_especial' => env('STRIPE_PLAN_ESPECIAL'),
        ]
    ]
];