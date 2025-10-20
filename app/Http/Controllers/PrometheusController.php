<?php

namespace App\Http\Controllers;

use App\Services\Prometheus\PrometheusService;
use App\Services\Prometheus\LaravelMetricsCollector;
use Illuminate\Http\Response;

class PrometheusController extends Controller
{
    private PrometheusService $prometheus;
    private LaravelMetricsCollector $collector;

    public function __construct(PrometheusService $prometheus, LaravelMetricsCollector $collector)
    {
        $this->prometheus = $prometheus;
        $this->collector = $collector;
    }

    public function metrics(): Response
    {
        try {
            // Collect current metrics
            $this->collector->collectSystemMetrics();
            $this->collector->collectApplicationMetrics();

            // Render metrics in Prometheus format
            $metrics = $this->prometheus->renderMetrics();

            return response($metrics, 200, [
                'Content-Type' => 'text/plain; version=0.0.4; charset=utf-8',
            ]);
        } catch (\Exception $e) {
            // Return error metrics if collection fails
            $errorMetrics = "# HELP laravel_metrics_collection_errors_total Total number of metrics collection errors\n";
            $errorMetrics .= "# TYPE laravel_metrics_collection_errors_total counter\n";
            $errorMetrics .= "laravel_metrics_collection_errors_total 1\n";

            return response($errorMetrics, 500, [
                'Content-Type' => 'text/plain; version=0.0.4; charset=utf-8',
            ]);
        }
    }
}