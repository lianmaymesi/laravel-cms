<?php

// config for Lianmaymesi/LaravelCms
return [
    'header' => env('LARAVEL_CMS_HEADER_SCRIPTS', 'header-scripts'),
    'route_prefix' => env('LARAVEL_CMS_ROUTE_PREFIX', 'cms'),
    'navigation' => [
        'top' => env('LARAVEL_CMS_NAV_TOP', 'navigation-top'),
        'bottom' => env('LARAVEL_CMS_NAV_BOTTOM', 'navigation-bottom'),
        'logout' => env('LARAVEL_CMS_LOGOUT', 'logout'),
    ],
    'preview_url' => env('LARAVEL_CMS_PREVIEW_URL'),
    'live_url' => env('LARAVEL_CMS_LIVE_URL'),
    'storage_driver' => env('LARAVEL_CMS_STORAGE_DISK', 'public'),
    'super_admin_email' => env('LARAVEL_CMS_SUPER_ADMIN_EMAIL', 'superadmin@catalizo.com'), // Password is Secret@143
];
