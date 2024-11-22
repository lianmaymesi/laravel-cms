<?php

// config for Lianmaymesi/LaravelCms
return [
    'header' => env('LARAVEL_CMS_HEADER_SCRIPTS', 'header-scripts'),
    'route_prefix' => env('LARAVEL_CMS_ROUTE_PREFIX', 'cms'),
    'navigation' => [
        'top' => env('LARAVEL_CMS_NAV_TOP', 'navigation-top'),
        'bottom' => env('LARAVEL_CMS_NAV_BOTTOM', 'navigation-bottom')
    ]
];
