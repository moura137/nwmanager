<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => env('AWS_SES_KEY', ''),
        'secret' => env('AWS_SES_SECRET', ''),
        'region' => env('AWS_SES_REGION', 'us-west-2'),
    ],

    'stripe' => [
        'model'  => NwManager\User::class,
        'key'    => '',
        'secret' => '',
    ],

];
