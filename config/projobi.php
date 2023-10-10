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
];