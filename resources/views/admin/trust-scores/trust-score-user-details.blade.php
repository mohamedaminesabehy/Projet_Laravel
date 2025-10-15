@extends('layouts.admin')

@section('title', 'Détails du Score de Confiance')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<style>
    body {
        background-color: #f8f9fa;
    }
    .trust-detail-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    .trust-score-display {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        color: white;
        margin: 20px auto;
    }
    .trust-score-excellent {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        box-shadow: 0 8px 30px rgba(17, 153, 142, 0.3);
    }
    .trust-score-good {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
    }
    .trust-score-medium {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        box-shadow: 0 8px 30px rgba(240, 147, 251, 0.3);
    }
    .trust-score-low {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        box-shadow: 0 8px 30px rgba(250, 112, 154, 0.3);
    }
    .trust-metric-item {
        padding: 20px;
        border-radius: 10px;
        background: white;
        margin-bottom: 15px;
        border-left: 4px solid #4e73df;
        transition: all 0.3s ease;
    }
    .trust-metric-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .trust-chart-container {
        height: 300px;
        position: relative;
    }
    .trust-action-btn {
        margin: 5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-user-shield text-primary"></i> 
                Détails du Score de Confiance
            </h1>
            <p class="text-muted mb-0">
                Analyse complète de : <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('admin.trust-scores.users') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <a href="{{ route('admin.trust-scores.index') }}" class="btn btn-info">
                <i class="fas fa-dashboard"></i> Dashboard
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

    <div class="row">
        <!-- Colonne gauche : Score et infos utilisateur -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <!-- Score principal -->
            <div class="card trust-detail-card">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-star"></i> Score de Confiance IA
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="trust-score-display 
                        @if($trustScore->trust_score >= 90) trust-score-excellent
                        @elseif($trustScore->trust_score >= 80) trust-score-good
                        @elseif($trustScore->trust_score >= 60) trust-score-medium
                        @else trust-score-low
                        @endif">
                        {{ $trustScore->trust_score }}
                    </div>
                    
                    <h4 class="mb-3">{{ $trustScore->trust_level }}</h4>
                    
                    @if($trustScore->is_verified)
                    <span class="badge badge-success badge-lg p-3">
                        <i class="fas fa-check-circle"></i> Utilisateur Vérifié
                    </span>
                    @elseif($trustScore->isSuspicious())
                    <span class="badge badge-danger badge-lg p-3">
                        <i class="fas fa-exclamation-triangle"></i> Utilisateur Suspect
                    </span>
                    @else
                    <span class="badge badge-secondary badge-lg p-3">
                        <i class="fas fa-user"></i> Utilisateur Standard
                    </span>
                    @endif

                    <div class="mt-4">
                        <p class="text-muted mb-1">
                            <i class="fas fa-clock"></i> Dernière mise à jour
                        </p>
                        <strong>
                            {{ $trustScore->last_calculated_at ? $trustScore->last_calculated_at->format('d/m/Y H:i') : 'Jamais' }}
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Informations utilisateur -->
            <div class="card trust-detail-card">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user"></i> Informations Utilisateur
                    </h6>
                </div>
                <div class="card-body">
                    <p><strong>Nom complet :</strong><br>{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p><strong>Email :</strong><br>{{ $user->email }}</p>
                    <p><strong>Rôle :</strong><br>
                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                            {{ $user->role }}
                        </span>
                    </p>
                    <p><strong>Membre depuis :</strong><br>
                        {{ $user->created_at->format('d/m/Y') }}
                        <small class="text-muted">({{ $trustScore->account_age_days }} jours)</small>
                    </p>
                    @if($trustScore->verification_date)
                    <p><strong>Vérifié le :</strong><br>{{ $trustScore->verification_date->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card trust-detail-card">
                <div class="card-header bg-warning text-dark">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-cogs"></i> Actions Admin
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.trust-scores.recalculate', $user->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block trust-action-btn">
                            <i class="fas fa-sync-alt"></i> Recalculer le Score
                        </button>
                    </form>

                    <form action="{{ route('admin.trust-scores.reset', $user->id) }}" method="POST" class="mb-2" 
                          onsubmit="return confirm('Réinitialiser le score à 50 et effacer l\'historique ?');">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-block trust-action-btn">
                            <i class="fas fa-undo"></i> Réinitialiser le Score
                        </button>
                    </form>

                    @if($trustScore->last_suspicious_activity)
                    <form action="{{ route('admin.trust-scores.resolve-suspicious', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Marquer cette alerte suspecte comme résolue ?');">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block trust-action-btn">
                            <i class="fas fa-check"></i> Résoudre l'Alerte
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne droite : Métriques et graphiques -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <!-- Métriques comportementales -->
            <div class="card trust-detail-card">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar"></i> Métriques Comportementales
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="trust-metric-item" style="border-left-color: #28a745;">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-handshake text-success"></i> Échanges Réussis
                                </h6>
                                <h3 class="mb-0">{{ $trustScore->successful_exchanges }}</h3>
                                <small class="text-muted">Contribue: +{{ min($trustScore->successful_exchanges * 5, 30) }} points</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="trust-metric-item" style="border-left-color: #dc3545;">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-times-circle text-danger"></i> Annulations de RDV
                                </h6>
                                <h3 class="mb-0">{{ $trustScore->cancelled_meetings }}</h3>
                                <small class="text-muted">Pénalité: -{{ min($trustScore->cancelled_meetings * 10, 30) }} points</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="trust-metric-item" style="border-left-color: #17a2b8;">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-comments text-info"></i> Messages
                                </h6>
                                <h3 class="mb-0">
                                    <span class="badge badge-info mr-2">{{ $trustScore->messages_sent }}</span> envoyés
                                    <span class="badge badge-info ml-2">{{ $trustScore->messages_received }}</span> reçus
                                </h3>
                                <small class="text-muted">
                                    Total: {{ $trustScore->messages_sent + $trustScore->messages_received }}
                                    @if(($trustScore->messages_sent + $trustScore->messages_received) > 20)
                                    (Bonus: +10 points)
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="trust-metric-item" style="border-left-color: #ffc107;">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-star text-warning"></i> Avis
                                </h6>
                                <h3 class="mb-0">
                                    <span class="badge badge-warning mr-2">{{ $trustScore->reviews_given }}</span> donnés
                                    <span class="badge badge-warning ml-2">{{ $trustScore->reviews_received }}</span> reçus
                                </h3>
                                <small class="text-muted">Contribue: +{{ min($trustScore->reviews_received * 5, 20) }} points</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activité suspecte -->
            @if($trustScore->last_suspicious_activity)
            <div class="card trust-detail-card border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-exclamation-triangle"></i> Activité Suspecte Détectée
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger mb-0">
                        <p class="mb-2"><strong>Raison :</strong></p>
                        <p class="mb-2">{{ $trustScore->last_suspicious_activity }}</p>
                        <p class="mb-0">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> Détecté le : 
                                {{ $trustScore->last_suspicious_at?->format('d/m/Y à H:i') }}
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Historique des scores -->
            <div class="card trust-detail-card">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-history"></i> Historique des Scores (30 dernières entrées)
                    </h6>
                </div>
                <div class="card-body">
                    @if(!empty($scoreHistory) && count($scoreHistory) > 0)
                    <div class="trust-chart-container">
                        <canvas id="trustScoreHistoryChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <p class="text-muted mb-2">
                            <i class="fas fa-info-circle"></i> Évolution du score sur les {{ count($scoreHistory) }} derniers calculs
                        </p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Score le plus bas :</strong>
                                <span class="badge badge-danger">
                                    {{ min(array_column($scoreHistory, 'score')) }}
                                </span>
                            </div>
                            <div>
                                <strong>Score le plus haut :</strong>
                                <span class="badge badge-success">
                                    {{ max(array_column($scoreHistory, 'score')) }}
                                </span>
                            </div>
                            <div>
                                <strong>Score actuel :</strong>
                                <span class="badge badge-primary">
                                    {{ $trustScore->trust_score }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center text-muted p-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Aucun historique disponible pour le moment.</p>
                        <small>L'historique sera créé après le premier recalcul.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    @if(!empty($scoreHistory) && count($scoreHistory) > 0)
    // Graphique de l'historique des scores
    const ctxHistory = document.getElementById('trustScoreHistoryChart').getContext('2d');
    
    const historyData = @json($scoreHistory);
    const labels = historyData.map((item, index) => 'Calcul ' + (index + 1));
    const scores = historyData.map(item => item.score);
    const dates = historyData.map(item => new Date(item.date).toLocaleDateString('fr-FR'));

    const trustScoreHistoryChart = new Chart(ctxHistory, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Score de Confiance',
                data: scores,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return 'Date: ' + dates[index];
                        },
                        label: function(context) {
                            return 'Score: ' + context.parsed.y + '/100';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush
