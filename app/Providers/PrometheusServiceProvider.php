<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Prometheus\PrometheusService;
use App\Services\Prometheus\LaravelMetricsCollector;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PrometheusService::class, function ($app) {
            return new PrometheusService();
        });

        $this->app->singleton(LaravelMetricsCollector::class, function ($app) {
            return new LaravelMetricsCollector($app->make(PrometheusService::class));
        });
    }

    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../../config/prometheus.php' => config_path('prometheus.php'),
        ], 'prometheus-config');

        // Register middleware alias
        $this->app['router']->aliasMiddleware('prometheus', \App\Http\Middleware\PrometheusMiddleware::class);
    }
}