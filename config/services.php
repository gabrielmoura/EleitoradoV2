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
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE'),
        'admin' => env('TELEGRAM_BOT_ADMIN', 'YOUR TELEGRAM ID HERE'),
    ],
    'utalk' => [
        'key' => env('UTALK_KEY'),
    ],
    'slack' => [
        'general' => env('SLACK_GENERAL_WEBHOOK_URL'),
        'announcements' => env('SLACK_ANNOUNCEMENTS_WEBHOOK_URL'),
        'tech-dev-ops' => env('SLACK_TECH_DEV_OPS_WEBHOOK_URL'),
    ],
    'cep' => [
        'endpoint' => \Gabrielmoura\LaravelCep\EndpointOption::VIACEP,
    ],
];
