<?php

namespace App\Services\Prometheus;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class LaravelMetricsCollector
{
    private PrometheusService $prometheus;

    public function __construct(PrometheusService $prometheus)
    {
        $this->prometheus = $prometheus;
    }

    public function collectSystemMetrics(): void
    {
        $this->collectMemoryMetrics();
        $this->collectDatabaseMetrics();
        $this->collectCacheMetrics();
        $this->collectQueueMetrics();
    }

    private function collectMemoryMetrics(): void
    {
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);

        $this->prometheus->registerGauge(
            'laravel_memory_usage_bytes',
            'Current memory usage in bytes'
        )->set($memoryUsage);

        $this->prometheus->registerGauge(
            'laravel_memory_peak_bytes',
            'Peak memory usage in bytes'
        )->set($memoryPeak);
    }

    private function collectDatabaseMetrics(): void
    {
        try {
            // Collect database connection info
            $connections = config('database.connections');
            foreach ($connections as $name => $config) {
                try {
                    $pdo = DB::connection($name)->getPdo();
                    $this->prometheus->registerGauge(
                        'laravel_database_connection_status',
                        'Database connection status (1 = connected, 0 = disconnected)',
                        ['connection']
                    )->set(1, [$name]);
                } catch (\Exception $e) {
                    $this->prometheus->registerGauge(
                        'laravel_database_connection_status',
                        'Database connection status (1 = connected, 0 = disconnected)',
                        ['connection']
                    )->set(0, [$name]);
                }
            }

            // Collect query count (this would be better tracked via event listeners)
            $queryCount = DB::getQueryLog() ? count(DB::getQueryLog()) : 0;
            $this->prometheus->registerGauge(
                'laravel_database_queries_current_request',
                'Number of database queries in current request'
            )->set($queryCount);

        } catch (\Exception $e) {
            // Handle database collection errors gracefully
        }
    }

    private function collectCacheMetrics(): void
    {
        try {
            // Test cache connectivity
            $testKey = 'prometheus_cache_test_' . time();
            Cache::put($testKey, 'test', 1);
            $cacheWorking = Cache::get($testKey) === 'test';
            Cache::forget($testKey);

            $this->prometheus->registerGauge(
                'laravel_cache_status',
                'Cache system status (1 = working, 0 = not working)'
            )->set($cacheWorking ? 1 : 0);

        } catch (\Exception $e) {
            $this->prometheus->registerGauge(
                'laravel_cache_status',
                'Cache system status (1 = working, 0 = not working)'
            )->set(0);
        }
    }

    private function collectQueueMetrics(): void
    {
        try {
            // This is a basic implementation - in production you'd want more detailed queue metrics
            $this->prometheus->registerGauge(
                'laravel_queue_status',
                'Queue system status (1 = configured, 0 = not configured)'
            )->set(config('queue.default') !== 'sync' ? 1 : 0);

        } catch (\Exception $e) {
            $this->prometheus->registerGauge(
                'laravel_queue_status',
                'Queue system status (1 = configured, 0 = not configured)'
            )->set(0);
        }
    }

    public function collectApplicationMetrics(): void
    {
        // Collect Laravel version
        $this->prometheus->registerGauge(
            'laravel_version_info',
            'Laravel version information',
            ['version']
        )->set(1, [app()->version()]);

        // Collect PHP version
        $this->prometheus->registerGauge(
            'laravel_php_version_info',
            'PHP version information',
            ['version']
        )->set(1, [PHP_VERSION]);

        // Collect environment
        $this->prometheus->registerGauge(
            'laravel_environment_info',
            'Laravel environment information',
            ['environment']
        )->set(1, [app()->environment()]);

        // Collect debug mode status
        $this->prometheus->registerGauge(
            'laravel_debug_mode',
            'Laravel debug mode status (1 = enabled, 0 = disabled)'
        )->set(config('app.debug') ? 1 : 0);
    }
}