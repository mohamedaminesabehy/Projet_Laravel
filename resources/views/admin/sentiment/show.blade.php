@extends('layouts.admin')

@section('title', 'Détails Analyse - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-microscope text-primary"></i> Analyse Détaillée - Avis #{{ $review->id }}
            </h1>
        </div>
        <div>
            <a href="{{ route('admin.sentiment.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <form action="{{ route('admin.sentiment.reanalyze', $review) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-sync-alt"></i> Ré-analyser
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Informations de base -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-book"></i> Avis Original</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Livre:</label>
                        <p>{{ $review->book->title ?? 'N/A' }} <small class="text-muted">par {{ $review->book->author ?? 'N/A' }}</small></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Utilisateur:</label>
                        <p>{{ $review->user->name ?? 'N/A' }} <small class="text-muted">({{ $review->user->email ?? 'N/A' }})</small></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Note:</label>
                        <div>
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                            <span class="ms-2">{{ $review->rating }}/5</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Commentaire:</label>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Date:</label>
                        <p>{{ $review->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Résumé IA -->
            @if($review->ai_summary)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-robot"></i> Résumé par IA</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $review->ai_summary }}</p>
                    </div>
                </div>
            @endif

            <!-- Thèmes extraits -->
            @if($review->ai_topics && count($review->ai_topics) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-tags"></i> Thèmes Détectés</h5>
                    </div>
                    <div class="card-body">
                        @foreach($review->ai_topics as $topic)
                            <span class="badge bg-info me-2 mb-2" style="font-size: 14px;">
                                <i class="fas fa-tag"></i> {{ $topic }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Scores et analyses -->
        <div class="col-md-4">
            <!-- Score de sentiment -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Sentiment</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        {!! $review->sentiment_badge !!}
                    </div>
                    
                    <div class="mb-3">
                        <h2 class="mb-0 {{ $review->sentiment_score > 0 ? 'text-success' : ($review->sentiment_score < 0 ? 'text-danger' : 'text-warning') }}">
                            {{ number_format($review->sentiment_score, 2) }}
                        </h2>
                        <small class="text-muted">Score de sentiment</small>
                    </div>

                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar {{ $review->sentiment_score > 0 ? 'bg-success' : 'bg-danger' }}" 
                             style="width: {{ (($review->sentiment_score + 1) / 2) * 100 }}%">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-danger">-1.0</small>
                        <small class="text-muted">0.0</small>
                        <small class="text-success">+1.0</small>
                    </div>
                </div>
            </div>

            <!-- Score de toxicité -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Toxicité</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h2 class="mb-0 {{ $review->toxicity_score > 0.7 ? 'text-danger' : ($review->toxicity_score > 0.4 ? 'text-warning' : 'text-success') }}">
                            {{ number_format($review->toxicity_score, 2) }}
                        </h2>
                        <small class="text-muted">Score de toxicité</small>
                    </div>

                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-danger" 
                             style="width: {{ $review->toxicity_score * 100 }}%">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-success">0.0</small>
                        <small class="text-warning">0.5</small>
                        <small class="text-danger">1.0</small>
                    </div>

                    @if($review->toxicity_score > 0.5)
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle"></i> Toxicité élevée détectée
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statut de revue -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statut</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small">Modération:</label>
                        <div>
                            @if($review->is_approved)
                                <span class="badge bg-success"><i class="fas fa-check"></i> Approuvé</span>
                            @else
                                <span class="badge bg-warning"><i class="fas fa-clock"></i> En attente</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Revue manuelle:</label>
                        <div>
                            @if($review->requires_manual_review)
                                <span class="badge bg-danger"><i class="fas fa-flag"></i> Requise</span>
                            @else
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Non nécessaire</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small">Analysé le:</label>
                        <p class="mb-0">
                            @if($review->analyzed_at)
                                {{ $review->analyzed_at->format('d/m/Y à H:i') }}
                                <br>
                                <small class="text-muted">{{ $review->analyzed_at->diffForHumans() }}</small>
                            @else
                                <span class="text-muted">Non analysé</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Réactions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Réactions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <i class="fas fa-thumbs-up fa-2x text-success"></i>
                            <div class="mt-2">
                                <strong>{{ $review->likes_count }}</strong>
                                <div class="small text-muted">Likes</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-thumbs-down fa-2x text-danger"></i>
                            <div class="mt-2">
                                <strong>{{ $review->dislikes_count }}</strong>
                                <div class="small text-muted">Dislikes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
