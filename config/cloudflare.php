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
    'email' => env('CLOUDFLARE_EMAIL', ''),
    'api_key' => env('CLOUDFLARE_API_KEY', ''),
    'api_token' => env('CLOUDFLARE_API_TOKEN', ''),
    'fallback_origin' => env('CLOUDFLARE_FALLBACK_ORIGIN', 'fallback1.dzora.net'),

    /*
    | Custom Nameservers (Vanity NS)
    */
    'nameserver_1' => env('CLOUDFLARE_NS1', 'ns1.dzora.net'),
    'nameserver_2' => env('CLOUDFLARE_NS2', 'ns2.dzora.net'),

    /*
    | API Base URL
    */
    'api_base_url' => env('CLOUDFLARE_API_BASE_URL', 'https://api.cloudflare.com/client/v4'),
];
