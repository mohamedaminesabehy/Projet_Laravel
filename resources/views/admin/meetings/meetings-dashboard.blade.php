@extends('layouts.admin')

@section('title', 'Dashboard Meetings')

@push('styles')
<style>
    /* Amélioration de la lisibilité */
    .text-gray-800 {
        color: #1a202c !important;
    }
    
    .text-gray-700 {
        color: #2d3748 !important;
    }
    
    .text-gray-600 {
        color: #4a5568 !important;
    }
    
    .card-header h6 {
        color: #c9848f !important;
        font-weight: 700;
    }
    
    .table thead th {
        color: #1a202c !important;
        font-weight: 700;
        background-color: #f7fafc;
    }
    
    .table tbody td {
        color: #2d3748 !important;
        font-weight: 500;
    }
    
    .badge {
        font-size: 13px;
        font-weight: 600;
        padding: 6px 12px;
    }
    
    .border-left-primary {
        border-left: 4px solid #c9848f !important;
    }
    
    .border-left-success {
        border-left: 4px solid #c9848f !important;
    }
    
    .text-primary {
        color: #c9848f !important;
    }
    
    .text-success {
        color: #c9848f !important;
    }
    
    .btn-primary {
        background-color: #c9848f;
        border-color: #c9848f;
    }
    
    .btn-primary:hover {
        background-color: #b67680;
        border-color: #b67680;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-line"></i> Dashboard des Meetings
        </h1>
        <div>
            <a href="{{ route('admin.meetings.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Liste complète
            </a>
            <a href="{{ route('admin.meetings.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> CSV
            </a>
            <a href="{{ route('admin.meetings.export.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Proposés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['proposed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Confirmés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['confirmed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Terminés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flag-checkered fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Annulés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['cancelled'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">À venir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['upcoming'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-right fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Passés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['past'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique des meetings par mois -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Meetings par mois (6 derniers mois)</h6>
                </div>
                <div class="card-body">
                    <canvas id="meetingsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition par statut</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Meetings à venir -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Meetings à venir</h6>
                </div>
                <div class="card-body">
                    @forelse($upcomingMeetings as $meeting)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $meeting->user1->name }} ↔ {{ $meeting->user2->name }}
                                    </h6>
                                    <p class="mb-1 text-muted small">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $meeting->meeting_date->format('d/m/Y') }} à
                                        {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}
                                    </p>
                                    <p class="mb-0 text-muted small">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ Str::limit($meeting->meeting_place, 40) }}
                                    </p>
                                </div>
                                <span class="badge badge-{{ $meeting->status === 'confirmed' ? 'success' : 'warning' }}">
                                    {{ $meeting->status_text }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Aucun meeting à venir</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Meetings récents</h6>
                </div>
                <div class="card-body">
                    @forelse($recentMeetings as $meeting)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $meeting->user1->name }} ↔ {{ $meeting->user2->name }}
                                    </h6>
                                    <p class="mb-1 text-muted small">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $meeting->meeting_date->format('d/m/Y') }}
                                    </p>
                                    @if($meeting->book1 || $meeting->book2)
                                        <p class="mb-0 text-muted small">
                                            <i class="fas fa-book mr-1"></i>
                                            @if($meeting->book1){{ Str::limit($meeting->book1->title, 20) }}@endif
                                            @if($meeting->book1 && $meeting->book2) ↔ @endif
                                            @if($meeting->book2){{ Str::limit($meeting->book2->title, 20) }}@endif
                                        </p>
                                    @endif
                                </div>
                                @php
                                    $badges = [
                                        'proposed' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'info',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge badge-{{ $badges[$meeting->status] ?? 'secondary' }}">
                                    {{ $meeting->status_text }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Aucun meeting récent</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Graphique des meetings par mois
const ctx = document.getElementById('meetingsChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($monthlyMeetings, 'month')) !!},
        datasets: [{
            label: 'Meetings',
            data: {!! json_encode(array_column($monthlyMeetings, 'count')) !!},
            borderColor: 'rgb(78, 115, 223)',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Graphique de répartition par statut
const ctx2 = document.getElementById('statusChart');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Proposés', 'Confirmés', 'Terminés', 'Annulés'],
        datasets: [{
            data: [
                {{ $stats['proposed'] }},
                {{ $stats['confirmed'] }},
                {{ $stats['completed'] }},
                {{ $stats['cancelled'] }}
            ],
            backgroundColor: [
                'rgb(246, 194, 62)',
                'rgb(28, 200, 138)',
                'rgb(54, 185, 204)',
                'rgb(231, 74, 59)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
