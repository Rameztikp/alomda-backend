<?php

return [
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
        'storage/*',
        'images/*'  // أضف هذا السطر إذا كنت تستخدم مجلد images
    ],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://192.168.223.1:3000',
        'http://172.16.6.42:3000',
        'http://172.16.6.42:8000',
        'http://localhost:8000',
        'http://127.0.0.1:8000'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Auth-Token',
        'Origin',
        'Authorization',
        'X-Requested-With',
        'Accept'
    ],

    'exposed_headers' => ['Authorization'],

    'max_age' => 60 * 60 * 2,  // 2 ساعة

    'supports_credentials' => true,
];