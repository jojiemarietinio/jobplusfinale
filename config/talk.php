<?php

return [
    'user' => [
        'model' => 'App\User',
    ],
    'broadcast' => [
        'enable' => false,
        'app_name' => 'jobplus',
        'pusher' => [
            'app_id' => '406902',
            'app_key' => 'e803d31a97038b65ecc5',
            'app_secret' => 'ad4f6971d57bf2f9dc8a',
            'options' => [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        ],
    ],
];
