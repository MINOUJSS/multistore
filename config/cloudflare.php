<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudflare for SaaS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration values for integrating Cloudflare SSL for SaaS custom hostnames.
    |
    */

    'account_id' => env('CLOUDFLARE_ACCOUNT_ID', ''),
    'zone_id' => env('CLOUDFLARE_ZONE_ID', ''),
    'api_token' => env('CLOUDFLARE_API_TOKEN', ''),
    'fallback_origin' => env('CLOUDFLARE_FALLBACK_ORIGIN', 'fallback1.dzora.net'),

    /*
    | API Base URL
    */
    'api_base_url' => env('CLOUDFLARE_API_BASE_URL', 'https://api.cloudflare.com/client/v4'),
];
