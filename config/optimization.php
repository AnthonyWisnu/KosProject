<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure caching behavior for the application
    |
    */

    'cache' => [
        'enabled' => env('CACHE_ENABLED', true),
        'duration' => env('CACHE_DURATION', 3600), // 1 hour default
        'prefix' => env('CACHE_PREFIX', 'kost_'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Optimization
    |--------------------------------------------------------------------------
    |
    | Settings for database query optimization
    |
    */

    'database' => [
        'eager_loading' => true,
        'log_slow_queries' => env('LOG_SLOW_QUERIES', true),
        'slow_query_threshold' => env('SLOW_QUERY_THRESHOLD', 1000), // milliseconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Optimization
    |--------------------------------------------------------------------------
    |
    | Configure image processing and optimization
    |
    */

    'images' => [
        'max_upload_size' => env('MAX_IMAGE_SIZE', 5120), // KB
        'thumbnails' => [
            'enabled' => true,
            'width' => 300,
            'height' => 300,
        ],
        'compression' => [
            'enabled' => true,
            'quality' => 85,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    |
    | Enable/disable performance monitoring features
    |
    */

    'monitoring' => [
        'enabled' => env('PERFORMANCE_MONITORING', false),
        'log_requests' => env('LOG_REQUESTS', false),
        'track_memory' => env('TRACK_MEMORY', false),
    ],

];
