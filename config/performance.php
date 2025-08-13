<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    */

    // Cache duration in seconds (1 week)
    'cache_duration' => 604800,

    // Enable/disable features
    'enable_compression' => true,
    'enable_minification' => true,
    'enable_image_optimization' => true,

    // Image optimization
    'max_image_width' => 2000,
    'jpeg_quality' => 85,
    'webp_quality' => 85,

    // Assets to be preloaded
    'preload' => [
        'fonts' => true,
        'critical_css' => true,
        'hero_images' => true,
    ],

    // Cache excluded paths
    'cache_excluded_paths' => [
        'admin/*',
        'api/*',
        'login',
        'register',
    ],

    // Browser cache duration for different types (in seconds)
    'browser_cache' => [
        'images' => 604800,      // 1 week
        'fonts' => 31536000,     // 1 year
        'css' => 31536000,       // 1 year
        'js' => 31536000,        // 1 year
    ],
];
