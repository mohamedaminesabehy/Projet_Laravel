<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Prometheus\PrometheusService;

class PrometheusMiddleware
{
    private PrometheusService $prometheus;

    public function __construct(PrometheusService $prometheus)
    {
        $this->prometheus = $prometheus;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = microtime(true) - $startTime;
        $method = $request->getMethod();
        $route = $request->route() ? $request->route()->getName() ?? $request->route()->uri() : 'unknown';
        $statusCode = $response->getStatusCode();

        // Increment request counter
        $this->prometheus->incrementCounter('http_requests_total', [
            'method' => $method,
            'route' => $route,
            'status_code' => (string) $statusCode,
        ]);

        // Observe request duration
        $this->prometheus->observeHistogram('http_request_duration_seconds', $duration, [
            'method' => $method,
            'route' => $route,
            'status_code' => (string) $statusCode,
        ]);

        return $response;
    }
}