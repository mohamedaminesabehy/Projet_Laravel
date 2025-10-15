@extends('layouts.admin')

@section('title', 'Scores de Confiance IA - Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<style>
    body {
        background-color: #f8f9fa;
    }
    .trust-stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .trust-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
    }
    .trust-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }
    .trust-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .trust-badge-verified {
        background-color: #d4edda;
        color: #155724;
    }
    .trust-badge-suspicious {
        background-color: #f8d7da;
        color: #721c24;
    }
    .trust-badge-standard {
        background-color: #fff3cd;
        color: #856404;
    }
    .trust-chart-container {
        position: relative;
        height: 350px;
        margin-bottom: 20px;
    }
    .trust-user-item {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        background-color: white;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    .trust-user-item:hover {
        background-color: #f9f9f9;
        border-color: #4e73df;
        transform: translateX(5px);
    }
    .trust-score-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }
    .trust-score-excellent {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .trust-score-good {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .trust-score-medium {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .trust-score-low {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-shield-alt text-primary"></i> Scores de Confiance IA
            </h1>
            <p class="text-muted mb-0">
                Système intelligent de vérification et de détection des comportements suspects
            </p>
        </div>
        <div>
            <a href="{{ route('admin.trust-scores.users') }}" class="btn btn-primary">
                <i class="fas fa-users"></i> Voir tous les utilisateurs
            </a>
            <form action="{{ route('admin.trust-scores.recalculate-all') }}" method="POST" style="display: inline;" onsubmit="return confirm('Recalculer les scores de TOUS les utilisateurs ? Cela peut prendre du temps.');">
                @csrf
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-sync-alt"></i> Recalculer tout
                </button>
            </form>
            <a href="{{ route('admin.trust-scores.export-csv') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exporter CSV
            </a>
        </div>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card trust-stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="trust-icon bg-white text-primary mx-auto">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-center mb-2">{{ $stats['total_users'] }}</h3>
                    <p class="text-center mb-0 font-weight-bold">Utilisateurs Total</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card trust-stat-card bg-success text-white">
                <div class="card-body">
                    <div class="trust-icon bg-white text-success mx-auto">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-center mb-2">{{ $stats['verified_users'] }}</h3>
                    <p class="text-center mb-0 font-weight-bold">Utilisateurs Vérifiés</p>
                    <small class="d-block text-center mt-1">(Score ≥ 80)</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card trust-stat-card bg-danger text-white">
                <div class="card-body">
                    <div class="trust-icon bg-white text-danger mx-auto">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-center mb-2">{{ $stats['suspicious_users'] }}</h3>
                    <p class="text-center mb-0 font-weight-bold">Utilisateurs Suspects</p>
                    <small class="d-block text-center mt-1">(Score < 40 ou alerte)</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card trust-stat-card bg-info text-white">
                <div class="card-body">
                    <div class="trust-icon bg-white text-info mx-auto">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-center mb-2">{{ $stats['average_score'] }}</h3>
                    <p class="text-center mb-0 font-weight-bold">Score Moyen</p>
                    <small class="d-block text-center mt-1">(Sur 100)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et listes -->
    <div class="row">
        <!-- Distribution des scores -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card shadow trust-stat-card">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie"></i> Distribution des Scores
                    </h6>
                </div>
                <div class="card-body">
                    <div class="trust-chart-container">
                        <canvas id="trustScoreDistributionChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-success"></i> Excellent (90-100)</span>
                            <strong>{{ $stats['excellent_users'] }} utilisateurs</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-primary"></i> Bon (60-89)</span>
                            <strong>{{ $stats['good_users'] }} utilisateurs</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-circle text-warning"></i> Faible (< 60)</span>
                            <strong>{{ $stats['low_users'] }} utilisateurs</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 meilleurs utilisateurs -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card shadow trust-stat-card">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-trophy"></i> Top 10 Utilisateurs (Meilleurs Scores)
                    </h6>
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                    @forelse($topUsers as $trustScore)
                    <div class="trust-user-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="trust-score-circle 
                                @if($trustScore->trust_score >= 90) trust-score-excellent
                                @elseif($trustScore->trust_score >= 80) trust-score-good
                                @elseif($trustScore->trust_score >= 60) trust-score-medium
                                @else trust-score-low
                                @endif">
                                {{ $trustScore->trust_score }}
                            </div>
                            <div class="ml-3">
                                <h6 class="mb-1">
                                    {{ $trustScore->user->first_name }} {{ $trustScore->user->last_name }}
                                    @if($trustScore->is_verified)
                                    <span class="badge badge-success ml-2">
                                        <i class="fas fa-check-circle"></i> Vérifié
                                    </span>
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $trustScore->user->email }}</small><br>
                                <small class="badge badge-info">{{ $trustScore->trust_level }}</small>
                            </div>
                        </div>
                        <a href="{{ route('admin.trust-scores.show', $trustScore->user->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @empty
                    <p class="text-center text-muted">Aucun utilisateur trouvé.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Utilisateurs suspects -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow trust-stat-card">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-exclamation-circle"></i> Utilisateurs Suspects (Attention requise)
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($suspiciousUsers as $trustScore)
                    <div class="trust-user-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-grow-1">
                            <div class="trust-score-circle trust-score-low">
                                {{ $trustScore->trust_score }}
                            </div>
                            <div class="ml-3 flex-grow-1">
                                <h6 class="mb-1">
                                    {{ $trustScore->user->first_name }} {{ $trustScore->user->last_name }}
                                    <span class="badge badge-danger ml-2">
                                        <i class="fas fa-exclamation-triangle"></i> Suspect
                                    </span>
                                </h6>
                                <small class="text-muted d-block">{{ $trustScore->user->email }}</small>
                                @if($trustScore->last_suspicious_activity)
                                <small class="text-danger d-block mt-1">
                                    <i class="fas fa-info-circle"></i> <strong>Raison:</strong> {{ $trustScore->last_suspicious_activity }}
                                </small>
                                <small class="text-muted">
                                    Détecté le: {{ $trustScore->last_suspicious_at?->format('d/m/Y H:i') }}
                                </small>
                                @endif
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.trust-scores.show', $trustScore->user->id) }}" class="btn btn-sm btn-outline-primary mr-2">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                            <form action="{{ route('admin.trust-scores.resolve-suspicious', $trustScore->user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Marquer cette alerte comme résolue ?');">
                                    <i class="fas fa-check"></i> Résoudre
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-success p-4">
                        <i class="fas fa-smile fa-3x mb-3"></i>
                        <h5>Aucun utilisateur suspect détecté !</h5>
                        <p class="text-muted">Le système IA n'a détecté aucun comportement anormal.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Utilisateurs récemment vérifiés -->
    @if($recentlyVerified->count() > 0)
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow trust-stat-card">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-star"></i> Utilisateurs Récemment Vérifiés
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($recentlyVerified as $trustScore)
                        <div class="col-md-4 mb-3">
                            <div class="trust-user-item">
                                <div class="d-flex align-items-center">
                                    <div class="trust-score-circle trust-score-excellent">
                                        {{ $trustScore->trust_score }}
                                    </div>
                                    <div class="ml-3">
                                        <h6 class="mb-1">
                                            {{ $trustScore->user->first_name }} {{ $trustScore->user->last_name }}
                                        </h6>
                                        <small class="text-muted d-block">
                                            Vérifié le: {{ $trustScore->verification_date?->format('d/m/Y') }}
                                        </small>
                                        <a href="{{ route('admin.trust-scores.show', $trustScore->user->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Graphique de distribution des scores
    const ctxDistribution = document.getElementById('trustScoreDistributionChart').getContext('2d');
    const trustScoreDistributionChart = new Chart(ctxDistribution, {
        type: 'doughnut',
        data: {
            labels: ['Excellent (90-100)', 'Bon (60-89)', 'Faible (< 60)'],
            datasets: [{
                data: [
                    {{ $stats['excellent_users'] }},
                    {{ $stats['good_users'] }},
                    {{ $stats['low_users'] }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#4e73df',
                    '#ffc107'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = {{ $stats['total_users'] }};
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
