<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'admin_chat_id' => env('ADMIN_CHAT_ID'),
    ],
    'brevo' => [
        'key' => env('BREVO_API_KEY'),
        'dsn' => 'brevo+api://'.env('BREVO_API_KEY').'@default',
    ],
    'chargily' => [
        'mode' => env('CHARGILY_MODE', 'test'),
        'public_key' => env('CHARGILY_PUBLIC_KEY', 'test_pk_dQD6KsE788otDQXgFrsVVzDt9wDmfo1dFupH5oKE'),
        'secret_key' => env('CHARGILY_SECRET_KEY', 'test_sk_gpdoJktjYvibE4ydPsWQs6tf062lu6Rj5N4hQCo3'),
    ],
];
