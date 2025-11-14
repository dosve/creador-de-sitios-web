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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'auth_eme10' => [
        'base_url' => env('AUTH_EME10_BASE_URL', 'https://auth.eme10.com/api'),
        'app_name' => env('AUTH_EME10_APP_NAME', 'Creador de Sitios Web'),
        'client_id' => env('AUTH_EME10_CLIENT_ID', '1'),
        'redirect_uri' => env('AUTH_EME10_REDIRECT_URI', env('APP_URL') . '/auth/oauth/callback'),
    ],

    'admin_negocios' => [
        'app_key' => env('ADMIN_NEGOCIOS_APP_KEY', '123456789'),
    ],

];
