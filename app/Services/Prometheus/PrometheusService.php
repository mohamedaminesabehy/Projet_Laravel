<?php

namespace App\Services\Prometheus;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;
use Prometheus\RenderTextFormat;
use Prometheus\Counter;
use Prometheus\Histogram;
use Prometheus\Gauge;

class PrometheusService
{
    private CollectorRegistry $registry;
    private array $config;
    private array $counters = [];
    private array $histograms = [];
    private array $gauges = [];

    public function __construct()
    {
        $this->config = config('prometheus');
        $this->initializeRegistry();
        $this->initializeDefaultMetrics();
    }

    private function initializeRegistry(): void
    {
        $adapter = $this->config['storage']['adapter'] ?? 'memory';

        switch ($adapter) {
            case 'redis':
                $redisConfig = $this->config['storage']['redis'];
                Redis::setDefaultOptions([
                    'host' => $redisConfig['host'],
                    'port' => $redisConfig['port'],
                    'password' => $redisConfig['password'],
                    'timeout' => $redisConfig['timeout'],
                    'read_timeout' => $redisConfig['read_timeout'],
                    'persistent_connections' => $redisConfig['persistent_connections'],
                    'prefix' => $redisConfig['prefix'],
                ]);
                $this->registry = new CollectorRegistry(new Redis());
                break;
            default:
                $this->registry = new CollectorRegistry(new InMemory());
                break;
        }
    }

    private function initializeDefaultMetrics(): void
    {
        $namespace = $this->config['namespace'];
        $defaultMetrics = $this->config['default_metrics'] ?? [];

        foreach ($defaultMetrics as $name => $config) {
            switch ($config['type']) {
                case 'counter':
                    $this->counters[$name] = $this->registry->getOrRegisterCounter(
                        $namespace,
                        $name,
                        $config['help'],
                        $config['labels'] ?? []
                    );
                    break;
                case 'histogram':
                    $this->histograms[$name] = $this->registry->getOrRegisterHistogram(
                        $namespace,
                        $name,
                        $config['help'],
                        $config['labels'] ?? [],
                        $config['buckets'] ?? null
                    );
                    break;
                case 'gauge':
                    $this->gauges[$name] = $this->registry->getOrRegisterGauge(
                        $namespace,
                        $name,
                        $config['help'],
                        $config['labels'] ?? []
                    );
                    break;
            }
        }
    }

    public function getRegistry(): CollectorRegistry
    {
        return $this->registry;
    }

    public function incrementCounter(string $name, array $labels = [], float $value = 1): void
    {
        if (isset($this->counters[$name])) {
            $this->counters[$name]->incBy($value, $labels);
        }
    }

    public function observeHistogram(string $name, float $value, array $labels = []): void
    {
        if (isset($this->histograms[$name])) {
            $this->histograms[$name]->observe($value, $labels);
        }
    }

    public function setGauge(string $name, float $value, array $labels = []): void
    {
        if (isset($this->gauges[$name])) {
            $this->gauges[$name]->set($value, $labels);
        }
    }

    public function incrementGauge(string $name, array $labels = [], float $value = 1): void
    {
        if (isset($this->gauges[$name])) {
            $this->gauges[$name]->incBy($value, $labels);
        }
    }

    public function decrementGauge(string $name, array $labels = [], float $value = 1): void
    {
        if (isset($this->gauges[$name])) {
            $this->gauges[$name]->decBy($value, $labels);
        }
    }

    public function renderMetrics(): string
    {
        $renderer = new RenderTextFormat();
        return $renderer->render($this->registry->getMetricFamilySamples());
    }

    public function registerCounter(string $name, string $help, array $labels = []): Counter
    {
        $namespace = $this->config['namespace'];
        $counter = $this->registry->getOrRegisterCounter($namespace, $name, $help, $labels);
        $this->counters[$name] = $counter;
        return $counter;
    }

    public function registerHistogram(string $name, string $help, array $labels = [], array $buckets = null): Histogram
    {
        $namespace = $this->config['namespace'];
        $histogram = $this->registry->getOrRegisterHistogram($namespace, $name, $help, $labels, $buckets);
        $this->histograms[$name] = $histogram;
        return $histogram;
    }

    public function registerGauge(string $name, string $help, array $labels = []): Gauge
    {
        $namespace = $this->config['namespace'];
        $gauge = $this->registry->getOrRegisterGauge($namespace, $name, $help, $labels);
        $this->gauges[$name] = $gauge;
        return $gauge;
    }
}