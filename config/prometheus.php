<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Prometheus Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Prometheus metrics collection and export
    |
    */

    'namespace' => env('PROMETHEUS_NAMESPACE', 'laravel_app'),

    'route' => [
        'enabled' => env('PROMETHEUS_METRICS_ROUTE_ENABLED', true),
        'path' => env('PROMETHEUS_METRICS_ROUTE_PATH', 'metrics'),
        'middleware' => env('PROMETHEUS_METRICS_ROUTE_MIDDLEWARE', null),
    ],

    'storage' => [
        'adapter' => env('PROMETHEUS_STORAGE_ADAPTER', 'memory'),
        'redis' => [
            'host' => env('PROMETHEUS_REDIS_HOST', env('REDIS_HOST', '127.0.0.1')),
            'port' => env('PROMETHEUS_REDIS_PORT', env('REDIS_PORT', 6379)),
            'password' => env('PROMETHEUS_REDIS_PASSWORD', env('REDIS_PASSWORD', null)),
            'timeout' => env('PROMETHEUS_REDIS_TIMEOUT', 0.1),
            'read_timeout' => env('PROMETHEUS_REDIS_READ_TIMEOUT', 10),
            'persistent_connections' => env('PROMETHEUS_REDIS_PERSISTENT_CONNECTIONS', false),
            'prefix' => env('PROMETHEUS_REDIS_PREFIX', 'PROMETHEUS_'),
        ],
    ],

    'collectors' => [
        // Add your custom collectors here
        \App\Services\Prometheus\LaravelMetricsCollector::class,
    ],

    'default_metrics' => [
        'http_requests_total' => [
            'type' => 'counter',
            'help' => 'Total number of HTTP requests',
            'labels' => ['method', 'route', 'status_code'],
        ],
        'http_request_duration_seconds' => [
            'type' => 'histogram',
            'help' => 'HTTP request duration in seconds',
            'labels' => ['method', 'route', 'status_code'],
            'buckets' => [0.005, 0.01, 0.025, 0.05, 0.075, 0.1, 0.25, 0.5, 0.75, 1.0, 2.5, 5.0, 7.5, 10.0],
        ],
        'laravel_queue_jobs_total' => [
            'type' => 'counter',
            'help' => 'Total number of queue jobs processed',
            'labels' => ['queue', 'status'],
        ],
        'laravel_cache_operations_total' => [
            'type' => 'counter',
            'help' => 'Total number of cache operations',
            'labels' => ['operation', 'status'],
        ],
        'laravel_database_queries_total' => [
            'type' => 'counter',
            'help' => 'Total number of database queries',
            'labels' => ['connection', 'type'],
        ],
        'laravel_database_query_duration_seconds' => [
            'type' => 'histogram',
            'help' => 'Database query duration in seconds',
            'labels' => ['connection', 'type'],
            'buckets' => [0.001, 0.005, 0.01, 0.025, 0.05, 0.1, 0.25, 0.5, 1.0, 2.5, 5.0],
        ],
    ],
];