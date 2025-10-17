@extends('layouts.admin')

@section('title', 'Review Statistics - BookShare Admin')

@section('content')
<style>
    .stats-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .trend-up {
        color: #28a745;
    }
    .trend-down {
        color: #dc3545;
    }
    .chart-container {
        position: relative;
        height: 350px;
        margin-top: 20px;
    }
    .filter-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 30px;
    }
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
    .badge-rating {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-chart-line me-2"></i>Review Statistics Dashboard
            </h1>
            <p class="text-muted mb-0">Advanced analytics and insights for book reviews</p>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-download me-2"></i>Export Report
            </button>
        </div>
    </div>

    <!-- Date Filter Section -->
    <div class="filter-section">
        <form action="{{ route('admin.statistics.reviews') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>Start Date
                    </label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ $startDate->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar-check me-2"></i>End Date
                    </label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ $endDate->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-light w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Reviews -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Reviews</p>
                            <h2 class="mb-0">{{ number_format($totalReviews) }}</h2>
                            <small class="text-muted">
                                <i class="fas fa-arrow-{{ $monthlyGrowth >= 0 ? 'up' : 'down' }} me-1 trend-{{ $monthlyGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ number_format(abs($monthlyGrowth), 1) }}% vs last month
                            </small>
                        </div>
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Average Rating</p>
                            <h2 class="mb-0">{{ number_format($averageRating, 1) }}</h2>
                            <small class="text-muted">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $averageRating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </small>
                        </div>
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Reviews -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Approved Reviews</p>
                            <h2 class="mb-0">{{ number_format($approvedReviews) }}</h2>
                            <small class="text-muted">
                                {{ number_format($approvalRate, 1) }}% approval rate
                            </small>
                        </div>
                        <div class="stats-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pending Reviews</p>
                            <h2 class="mb-0">{{ number_format($pendingReviews) }}</h2>
                            <small class="text-muted">
                                Awaiting moderation
                            </small>
                        </div>
                        <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Daily Trend Chart -->
        <div class="col-xl-8">
            <div class="card stats-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>Reviews Trend
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Distribution -->
        <div class="col-xl-4">
            <div class="card stats-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-warning"></i>Rating Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ratingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Books and Reviewers -->
    <div class="row g-4 mb-4">
        <!-- Top Rated Books -->
        <div class="col-xl-6">
            <div class="card stats-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy me-2 text-success"></i>Top Rated Books
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book</th>
                                    <th>Reviews</th>
                                    <th>Avg Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topRatedBooks as $index => $book)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                            <span class="badge bg-warning">{{ $index + 1 }}</span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($book->title, 30) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $book->author }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $book->reviews_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-rating bg-success">
                                            <i class="fas fa-star"></i> {{ number_format($book->avg_rating, 1) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Reviewed Books -->
        <div class="col-xl-6">
            <div class="card stats-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-fire me-2 text-danger"></i>Most Reviewed Books
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book</th>
                                    <th>Reviews</th>
                                    <th>Avg Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mostReviewedBooks as $index => $book)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ Str::limit($book->title, 30) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $book->author }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $book->reviews_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-rating bg-success">
                                            <i class="fas fa-star"></i> {{ number_format($book->avg_rating, 1) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Reviewers -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card stats-card">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2 text-info"></i>Most Active Reviewers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reviewer</th>
                                    <th>Email</th>
                                    <th>Total Reviews</th>
                                    <th>Average Rating Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topReviewers as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas fa-user-circle me-2"></i>
                                        <strong>{{ $user->name }}</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $user->reviews_count }} reviews</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-rating bg-warning text-dark">
                                            <i class="fas fa-star"></i> {{ number_format($user->avg_rating, 1) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-download me-2"></i>Export Statistics Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="exportForm" action="{{ route('admin.statistics.reviews.export') }}" method="GET">
                    
                    <!-- Export Format Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-file-export me-2 text-primary"></i>Export Format
                        </label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check export-option">
                                    <input class="form-check-input" type="radio" name="format" id="formatPdf" value="pdf" checked>
                                    <label class="form-check-label w-100" for="formatPdf">
                                        <div class="export-card">
                                            <i class="fas fa-file-pdf text-danger fa-2x mb-2"></i>
                                            <h6 class="mb-1">PDF</h6>
                                            <small class="text-muted">Professional Report</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check export-option">
                                    <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel">
                                    <label class="form-check-label w-100" for="formatExcel">
                                        <div class="export-card">
                                            <i class="fas fa-file-excel text-success fa-2x mb-2"></i>
                                            <h6 class="mb-1">Excel</h6>
                                            <small class="text-muted">With Charts & Styles</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check export-option">
                                    <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv">
                                    <label class="form-check-label w-100" for="formatCsv">
                                        <div class="export-card">
                                            <i class="fas fa-file-csv text-info fa-2x mb-2"></i>
                                            <h6 class="mb-1">CSV</h6>
                                            <small class="text-muted">Comma Separated</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Date Range -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-warning"></i>Date Range
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Export Options -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-cog me-2 text-secondary"></i>Export Options
                        </label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="includeCharts" name="include_charts" checked>
                            <label class="form-check-label" for="includeCharts">
                                Include Charts & Graphs
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="includeSummary" name="include_summary" checked>
                            <label class="form-check-label" for="includeSummary">
                                Include Summary Statistics
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="includeDetails" name="include_details" checked>
                            <label class="form-check-label" for="includeDetails">
                                Include Detailed Reviews
                            </label>
                        </div>
                    </div>

                    <!-- File Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-signature me-2 text-info"></i>File Name (Optional)
                        </label>
                        <input type="text" name="filename" class="form-control" placeholder="review_statistics_{{ date('Y-m-d') }}">
                        <small class="text-muted">Leave blank for automatic naming</small>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> The file will be automatically downloaded to your Downloads folder.
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="exportForm" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download Report
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .export-option {
        position: relative;
    }
    .export-card {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    .export-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        transform: translateY(-3px);
    }
    .export-option input:checked ~ label .export-card {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    .export-option .form-check-input {
        position: absolute;
        opacity: 0;
    }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Trend Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyTrend->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('M d');
        })) !!},
        datasets: [{
            label: 'Reviews',
            data: {!! json_encode($dailyTrend->pluck('count')) !!},
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            fill: true,
            tension: 0.4
        }, {
            label: 'Avg Rating',
            data: {!! json_encode($dailyTrend->pluck('avg_rating')) !!},
            borderColor: '#f6ad55',
            backgroundColor: 'rgba(246, 173, 85, 0.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Number of Reviews'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Average Rating'
                },
                max: 5,
                min: 0,
                grid: {
                    drawOnChartArea: false,
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

// Rating Distribution Chart
const ratingCtx = document.getElementById('ratingChart').getContext('2d');
const ratingChart = new Chart(ratingCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ratingDistribution->pluck('rating')->map(function($rating) {
            return $rating . ' Stars';
        })) !!},
        datasets: [{
            data: {!! json_encode($ratingDistribution->pluck('count')) !!},
            backgroundColor: [
                '#f56565',
                '#ed8936',
                '#ecc94b',
                '#48bb78',
                '#38b2ac'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
