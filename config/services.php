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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'guzzle' => [
        'base_url' => env('GUZZLE_BASE_URL', null),
    ],

    'passport' => [
        'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
    ],

    'allowed_file_extensions' => [
        'images' => env('ALLOWED_IMAGE_EXT', ''),
        'files' => env('ALLOWED_FILE_EXT', ''),
    ],

    'exchange_rate' => [
        'endpoint' => env('RATE_EXCHANGE_ENDPOINT', ''),
        'version' => env('RATE_EXCHANGE_VERSION', ''),
        'api_key' => env('RATE_EXCHANGE_API_KEY', ''),
    ],

    'unifonic' => [
        'app_id' => env('UNIFONIC_APP_ID'),
        'sender_id' => env('UNIFONIC_SENDER_ID'), // String, Optional
        'account_email' => env('UNIFONIC_ACCOUNT_EMAIL'),
        'account_password' => env('UNIFONIC_ACCOUNT_PASSWORD')
    ],

    'google_map' => [
        'key' => env('GOOGLE_MAP_API_KEY', ''),
    ],

    'mapbox' => [
        'access_token' => env('MAPBOX_ACCESS_TOKEN', ''),
    ],

    'quickblox' => [
        'base_url' => env('QB_BASE_URL', ''),
        'application_id' => env('QB_APPLICATION_ID', ''),
        'authorization_key' => env('QB_AUTHORIZATION_KEY', ''),
        'authorization_secret' => env('QB_AUTHORIZATION_SECRET', ''),
        'account_key' => env('QB_ACCOUNT_KEY', ''),
    ],

    'twilio' => [
        'token' => env('TWILIO_AUTH_TOKEN', ''),
        'twilio_sid' => env('TWILIO_SID', ''),
        'twilio_verify_sid' => env('TWILIO_VERIFY_SID', ''),
    ],

    'fcm' => [
        'server_key' => env('FCM_SERVER_KEY', ''),
    ],

    'hyperpay' => [
        'endpoint' => env('HYPERPAY_ENDPOINT'),
        'payment_endpoint' => env('HYPERPAY_PAYMENT_ENDPOINT'),
        'entity_id' => env('HYPERPAY_ENTITY_ID'),
        'token' => env('HYPERPAY_TOKEN'),
        'ssl_verify_peer' => env('HYPERPAY_SSL_VERIFY'),
        'currency' => env('HYPERPAY_CURRENCY'),
        'payment_type' => env('HYPERPAY_PAYMENT_TYPE'),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect'      => env('FACEBOOK_URL'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect'      => env('GOOGLE_URL'),
    ],
];
