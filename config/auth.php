<?php

return [

    'defaults' => [
        'guard' => 'web', // Default guard to use
        'passwords' => 'users', // Default password reset settings
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'employer' => [
            'driver' => 'session',
            'provider' => 'employers',
        ],

        'writer' => [
            'driver' => 'session',
            'provider' => 'writers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'employers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Employer::class,
        ],

        'writers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Writer::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'employers' => [
            'provider' => 'employers',
            'table' => 'employer_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'writers' => [
            'provider' => 'writers',
            'table' => 'writer_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
