<?php

// config for Lianmaymesi/LaravelCms
return [
    'logo_url' => env('LARAVEL_CMS_LOGO_URL', 'logo_url'),
    'header' => env('LARAVEL_CMS_HEADER_SCRIPTS', 'header-scripts'),
    'footer' => env('LARAVEL_CMS_FOOTER_SCRIPTS', 'footer-scripts'),
    'route_prefix' => env('LARAVEL_CMS_ROUTE_PREFIX', 'cms'),
    'navigation' => [
        'top' => env('LARAVEL_CMS_NAV_TOP', 'navigation-top'),
        'bottom' => env('LARAVEL_CMS_NAV_BOTTOM', 'navigation-bottom'),
        'logout' => env('LARAVEL_CMS_LOGOUT', 'logout'),
        'settings_url' => env('LARAVEL_CMS_SETTINGS_URL', 'settings_url')
    ],
    'preview_url' => env('LARAVEL_CMS_PREVIEW_URL'),
    'live_url' => env('LARAVEL_CMS_LIVE_URL'),
    'storage_driver' => env('LARAVEL_CMS_STORAGE_DISK', 'public'),
    'super_admin_email' => env('LARAVEL_CMS_SUPER_ADMIN_EMAIL', 'superadmin@catalizo.com'), // Password is Secret@143
];
