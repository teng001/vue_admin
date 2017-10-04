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
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => '',
        'secret' => '',
    ],
    'company_scale' => [
        '1' => '0-50人',
        '2' => '50-100人',
        '3' => '100-500人',
        '4' => '500-1000人',
        '5' => '1000人以上'
    ],
    'wechat_appid' => 'wx1f9ac9a35b84ee60',
    'wechat_token' => '49de0375cf6211e3b3b6cb6ab035f633',
    'wechat_app_secret' => 'cd722880c552d578c4d4d48377c61974',
];
