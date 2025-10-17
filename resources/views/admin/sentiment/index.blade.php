@extends('layouts.admin')

@section('title', 'Analyse de Sentiment - Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="fas fa-brain text-primary"></i> Analyse de Sentiment AI</h1>
            <p class="text-muted mb-0">Analyse automatique des avis par intelligence artificielle</p>
        </div>
        <div>
            <a href="{{ route('admin.sentiment.analytics') }}" class="btn btn-info me-2">
                <i class="fas fa-chart-line"></i> Analytics
            </a>
            <a href="{{ route('admin.sentiment.export') }}" class="btn btn-success me-2">
                <i class="fas fa-download"></i> Export CSV
            </a>
            <form action="{{ route('admin.sentiment.bulk-analyze') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary position-relative">
                    <i class="fas fa-sync-alt"></i> Analyser en masse
                    @if($stats['pending_analysis'] > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $stats['pending_analysis'] }}
                            <span class="visually-hidden">avis en attente</span>
                        </span>
                    @endif
                </button>
            </form>
        </div>
    </div>

    <!-- Alerte pour avis non analysés -->
    @if($stats['pending_analysis'] > 0)
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>{{ $stats['pending_analysis'] }} avis en attente d'analyse.</strong>
        Cliquez sur "Analyser en masse" pour traiter {{ min($stats['pending_analysis'], 10) }} avis à la fois.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Analysés</p>
                            <h3 class="mb-0">{{ number_format($stats['total_analyzed']) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-primary fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Positifs</p>
                            <h3 class="mb-0 text-success">{{ number_format($stats['positive']) }}</h3>
                            <small class="text-muted">
                                {{ $stats['total_analyzed'] > 0 ? round(($stats['positive'] / $stats['total_analyzed']) * 100) : 0 }}%
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-smile text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Négatifs</p>
                            <h3 class="mb-0 text-danger">{{ number_format($stats['negative']) }}</h3>
                            <small class="text-muted">
                                {{ $stats['total_analyzed'] > 0 ? round(($stats['negative'] / $stats['total_analyzed']) * 100) : 0 }}%
                            </small>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-frown text-danger fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">À Revoir</p>
                            <h3 class="mb-0 text-warning">{{ number_format($stats['flagged']) }}</h3>
                            <small class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> Toxicité élevée: {{ $stats['high_toxicity'] }}
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-flag text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scores moyens -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Score de Sentiment Moyen</h6>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar {{ $stats['avg_sentiment'] > 0 ? 'bg-success' : 'bg-danger' }}" 
                                     style="width: {{ (($stats['avg_sentiment'] + 1) / 2) * 100 }}%">
                                    {{ $stats['avg_sentiment'] }}
                                </div>
                            </div>
                        </div>
                        <span class="ms-3 h5 mb-0">{{ $stats['avg_sentiment'] }}</span>
                    </div>
                    <small class="text-muted">-1.0 (Très négatif) à +1.0 (Très positif)</small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Score de Toxicité Moyen</h6>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-danger" 
                                     style="width: {{ $stats['avg_toxicity'] * 100 }}%">
                                    {{ $stats['avg_toxicity'] }}
                                </div>
                            </div>
                        </div>
                        <span class="ms-3 h5 mb-0">{{ $stats['avg_toxicity'] }}</span>
                    </div>
                    <small class="text-muted">0.0 (Pas toxique) à 1.0 (Très toxique)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sentiment.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Sentiment</label>
                    <select name="sentiment" class="form-select">
                        <option value="">Tous</option>
                        <option value="positive" {{ request('sentiment') == 'positive' ? 'selected' : '' }}>Positif</option>
                        <option value="neutral" {{ request('sentiment') == 'neutral' ? 'selected' : '' }}>Neutre</option>
                        <option value="negative" {{ request('sentiment') == 'negative' ? 'selected' : '' }}>Négatif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Statut</label>
                    <select name="flagged" class="form-select">
                        <option value="">Tous</option>
                        <option value="1" {{ request('flagged') == '1' ? 'selected' : '' }}>Signalés uniquement</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Toxicité min</label>
                    <select name="toxic" class="form-select">
                        <option value="">Tous</option>
                        <option value="0.3" {{ request('toxic') == '0.3' ? 'selected' : '' }}>≥ 0.3</option>
                        <option value="0.5" {{ request('toxic') == '0.5' ? 'selected' : '' }}>≥ 0.5</option>
                        <option value="0.7" {{ request('toxic') == '0.7' ? 'selected' : '' }}>≥ 0.7</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Recherche</label>
                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                </div>

                <div class="col-md-1">
                    <label class="form-label small">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des avis -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Avis Analysés ({{ $reviews->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th>Note</th>
                            <th>Sentiment</th>
                            <th>Score</th>
                            <th>Toxicité</th>
                            <th>Résumé IA</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr class="{{ $review->requires_manual_review ? 'bg-warning-subtle' : '' }}" style="{{ $review->requires_manual_review ? 'background-color: #fff3cd !important;' : '' }}">
                                <td><span class="badge bg-secondary">#{{ $review->id }}</span></td>
                                <td><strong>{{ $review->user->name ?? 'N/A' }}</strong></td>
                                <td class="small"><strong>{{ Str::limit($review->book->title ?? 'N/A', 30) }}</strong></td>
                                <td>
                                    @for($i = 0; $i < $review->rating; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                </td>
                                <td>{!! $review->sentiment_badge !!}</td>
                                <td>
                                    <span class="badge bg-{{ $review->sentiment_score > 0 ? 'success' : ($review->sentiment_score < 0 ? 'danger' : 'secondary') }}">
                                        {{ number_format($review->sentiment_score, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $review->toxicity_score > 0.7 ? 'danger' : ($review->toxicity_score > 0.4 ? 'warning' : 'success') }}">
                                        {{ number_format($review->toxicity_score, 2) }}
                                    </span>
                                </td>
                                <td class="small"><strong style="color: #212529;">{{ Str::limit($review->ai_summary, 50) }}</strong></td>
                                <td>
                                    @if($review->requires_manual_review)
                                        <span class="badge bg-warning text-dark"><i class="fas fa-flag"></i> À revoir</span>
                                    @else
                                        <span class="badge bg-success"><i class="fas fa-check"></i> OK</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.sentiment.show', $review) }}" class="btn btn-info" title="Détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.sentiment.reanalyze', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" title="Ré-analyser">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Aucun avis analysé pour le moment</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reviews->hasPages())
            <div class="card-footer bg-white">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
    }
    
    /* Amélioration de la lisibilité des lignes du tableau */
    .table > tbody > tr {
        background-color: #ffffff !important;
    }
    
    .table > tbody > tr:hover {
        background-color: #f8f9fa !important;
    }
    
    .bg-warning-subtle {
        background-color: #fff3cd !important;
    }
    
    .table > tbody > tr td {
        color: #212529 !important;
        font-weight: 500;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
    
    /* En-tête du tableau plus visible */
    .table-light th {
        background-color: #e9ecef !important;
        color: #212529 !important;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6 !important;
    }
</style>
@endpush
@endsection
