<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram Bot Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration values for Telegram Bot notifications, webhooks, and admin alerts.
    |
    */

    'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
    'admin_chat_id' => env('ADMIN_CHAT_ID', ''),

    /*
    | Base API URL for Telegram Bot API requests
    */
    'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org'),
];
