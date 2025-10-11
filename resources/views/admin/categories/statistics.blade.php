@extends('layouts.admin')

@section('title', 'Category Statistics')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
    .stats-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
    }
    
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    
    .chart-container {
        position: relative;
        height: 400px;
    }
    
    .table-stats {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .growth-positive {
        color: #10b981;
    }
    
    .growth-negative {
        color: #ef4444;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="stats-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2"><i class="fas fa-chart-bar me-2"></i>Category Statistics</h2>
                <p class="mb-0 opacity-90">Complete analytics and insights for all categories</p>
            </div>
            <div>
                <button class="btn btn-light" onclick="exportReport('csv')">
                    <i class="fas fa-download me-2"></i>Export CSV
                </button>
                <button class="btn btn-outline-light ms-2" onclick="exportReport('json')">
                    <i class="fas fa-file-code me-2"></i>Export JSON
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="fas fa-tags"></i>
                </div>
                <h6 class="text-muted mb-1">Total Categories</h6>
                <h3 class="mb-2 fw-bold">{{ number_format($totalCategories) }}</h3>
                <span class="{{ $monthlyGrowth >= 0 ? 'growth-positive' : 'growth-negative' }}">
                    <i class="fas fa-arrow-{{ $monthlyGrowth >= 0 ? 'up' : 'down' }} me-1"></i>
                    {{ number_format(abs($monthlyGrowth), 1) }}% vs last month
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <i class="fas fa-toggle-on"></i>
                </div>
                <h6 class="text-muted mb-1">Active Categories</h6>
                <h3 class="mb-2 fw-bold">{{ number_format($activeCategories) }}</h3>
                <span class="text-muted">
                    <i class="fas fa-percentage me-1"></i>
                    {{ $totalCategories > 0 ? number_format(($activeCategories / $totalCategories) * 100, 1) : 0 }}% of total
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <i class="fas fa-book"></i>
                </div>
                <h6 class="text-muted mb-1">Total Books</h6>
                <h3 class="mb-2 fw-bold">{{ number_format($totalBooks) }}</h3>
                <span class="text-muted">
                    <i class="fas fa-layer-group me-1"></i>
                    Across all categories
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h6 class="text-muted mb-1">Avg Books/Category</h6>
                <h3 class="mb-2 fw-bold">{{ number_format($avgBooksPerCategory, 1) }}</h3>
                <span class="text-muted">
                    <i class="fas fa-book me-1"></i>
                    Books per category
                </span>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row">
        <!-- Top Categories by Books -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Top Categories by Books</h5>
                </div>
                <div class="chart-container">
                    <canvas id="booksChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Categories by Favorites -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-heart me-2 text-danger"></i>Top Categories by Favorites</h5>
                </div>
                <div class="chart-container">
                    <canvas id="favoritesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="row">
        <!-- Status Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="chart-card">
                <h5 class="mb-3"><i class="fas fa-pie-chart me-2 text-success"></i>Status Distribution</h5>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Creation Trend -->
        <div class="col-lg-8 mb-4">
            <div class="chart-card">
                <h5 class="mb-3"><i class="fas fa-calendar me-2 text-warning"></i>Monthly Creation Trend (12 months)</h5>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Books vs Favorites Comparison -->
    <div class="chart-card mb-4">
        <h5 class="mb-3"><i class="fas fa-balance-scale me-2 text-info"></i>Books vs Favorites Comparison (Top 10)</h5>
        <div class="chart-container">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>

    <!-- Category Statistics Table -->
    <div class="table-stats mb-4">
        <div class="p-3 border-bottom">
            <h5 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>Detailed Category Statistics</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Category Name</th>
                        <th width="100">Color</th>
                        <th width="100" class="text-center">Status</th>
                        <th width="120" class="text-center">Books</th>
                        <th width="120" class="text-center">Favorites</th>
                        <th width="120" class="text-center">Unique Users</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categoryStats as $index => $category)
                    <tr>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                        <td>
                            <i class="{{ $category->icon ?? 'fas fa-tag' }} me-2" style="color: {{ $category->color }};"></i>
                            <strong style="color: #000;">{{ $category->name }}</strong>
                        </td>
                        <td>
                            <span class="category-badge" style="background-color: {{ $category->color }};">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                        </td>
                        <td class="text-center">
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary">
                                <i class="fas fa-book me-1"></i>{{ $category->books_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">
                                <i class="fas fa-heart me-1"></i>{{ $category->favorites_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">
                                <i class="fas fa-users me-1"></i>{{ $category->unique_users }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            No categories found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Empty Categories Alert -->
    @if($emptyCategories->count() > 0)
    <div class="table-stats">
        <div class="p-3 border-bottom bg-warning bg-opacity-10">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                Empty Categories ({{ $emptyCategories->count() }})
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Category Name</th>
                        <th width="150">Color</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="150">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emptyCategories as $category)
                    <tr>
                        <td>
                            <i class="{{ $category->icon ?? 'fas fa-tag' }} me-2" style="color: {{ $category->color }};"></i>
                            <strong style="color: #000;">{{ $category->name }}</strong>
                        </td>
                        <td>
                            <span class="category-badge" style="background-color: {{ $category->color }};">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                        </td>
                        <td class="text-center">
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $category->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Initialize charts on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeBooksChart();
        initializeFavoritesChart();
        initializeStatusChart();
        initializeMonthlyChart();
        initializeComparisonChart();
    });

    // Books Chart
    function initializeBooksChart() {
        const ctx = document.getElementById('booksChart').getContext('2d');
        
        fetch('{{ route('admin.categories.statistics.chart-data') }}?type=books')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Books Count',
                            data: data.values,
                            backgroundColor: data.colors.map(color => color + 'CC'),
                            borderColor: data.colors,
                            borderWidth: 2,
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
    }

    // Favorites Chart
    function initializeFavoritesChart() {
        const ctx = document.getElementById('favoritesChart').getContext('2d');
        
        fetch('{{ route('admin.categories.statistics.chart-data') }}?type=favorites')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Favorites Count',
                            data: data.values,
                            backgroundColor: data.colors.map(color => color + 'CC'),
                            borderColor: data.colors,
                            borderWidth: 2,
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
    }

    // Status Distribution Pie Chart
    function initializeStatusChart() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        fetch('{{ route('admin.categories.statistics.chart-data') }}?type=status')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: data.colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            });
    }

    // Monthly Creation Line Chart
    function initializeMonthlyChart() {
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        
        fetch('{{ route('admin.categories.statistics.chart-data') }}?type=monthly')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Categories Created',
                            data: data.values,
                            borderColor: '#fb923c',
                            backgroundColor: 'rgba(251, 146, 60, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#fb923c',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
    }

    // Books vs Favorites Comparison
    function initializeComparisonChart() {
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        
        fetch('{{ route('admin.categories.statistics.chart-data') }}?type=comparison')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Books',
                                data: data.books,
                                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                                borderColor: '#667eea',
                                borderWidth: 2,
                                borderRadius: 6,
                            },
                            {
                                label: 'Favorites',
                                data: data.favorites,
                                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                                borderColor: '#ef4444',
                                borderWidth: 2,
                                borderRadius: 6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
    }

    // Export report
    function exportReport(format) {
        const url = `{{ route('admin.categories.statistics.export') }}?format=${format}`;
        window.location.href = url;
    }
</script>
@endpush
