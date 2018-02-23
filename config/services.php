<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google_maps' => [
        'key' => env('GMAPS_KEY'),
        'icons' => [
            'origin' => 'http://liberi.dev/images/ini32.png',
            'destination' => 'http://liberi.dev/images/end32.png',
            'waypoint' => 'http://liberi.dev/images/waypoint32.png'
        ]
    ],
    'payment' => [
        'id' => env('PUSHER_APP_ID'),
        'key_public' => env('PUSHER_APP_KEY_PUBLIC'),
        'key_private' => env('PUSHER_APP_KEY_PRIVATE'),
        'url' => env('PUSHER_APP_URL'),
    ],

];
