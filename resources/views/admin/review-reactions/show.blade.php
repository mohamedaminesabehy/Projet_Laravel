@extends('layouts.admin')

@section('title', 'Détails de la Réaction')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-info-circle text-primary"></i> Détails de la Réaction
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.review-reactions.index') }}">Réactions</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.review-reactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Reaction Details -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-thumbs-up"></i> Informations de la Réaction
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Type de Réaction</label>
                        <div>
                            @if($reaction->reaction_type === 'like')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-thumbs-up"></i> LIKE
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-thumbs-down"></i> DISLIKE
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Date de Création</label>
                        <div class="fw-semibold">{{ $reaction->created_at->format('d/m/Y à H:i:s') }}</div>
                        <small class="text-muted">{{ $reaction->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Dernière Modification</label>
                        <div class="fw-semibold">{{ $reaction->updated_at->format('d/m/Y à H:i:s') }}</div>
                        @if($reaction->updated_at != $reaction->created_at)
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle"></i> Réaction modifiée
                            </small>
                        @endif
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">ID de la Réaction</label>
                        <div class="font-monospace">#{{ $reaction->id }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Utilisateur
                    </h5>
                </div>
                <div class="card-body">
                    @if($reaction->user)
                        <div class="text-center mb-3">
                            <div class="avatar-lg bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ strtoupper(substr($reaction->user->name, 0, 2)) }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Nom</label>
                            <div class="fw-bold fs-5">{{ $reaction->user->name }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Email</label>
                            <div>
                                <a href="mailto:{{ $reaction->user->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope"></i> {{ $reaction->user->email }}
                                </a>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="text-muted small">Statistiques</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="text-success fw-bold">{{ $reaction->user->reviewReactions()->where('reaction_type', 'like')->count() }}</div>
                                        <small class="text-muted">Likes donnés</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded text-center">
                                        <div class="text-danger fw-bold">{{ $reaction->user->reviewReactions()->where('reaction_type', 'dislike')->count() }}</div>
                                        <small class="text-muted">Dislikes donnés</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Utilisateur non disponible
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Review Details -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-star"></i> Avis Concerné
                    </h5>
                </div>
                <div class="card-body">
                    @if($reaction->review)
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="text-muted small">Livre</label>
                                <div class="fw-bold">{{ $reaction->review->book->title ?? 'N/A' }}</div>
                                @if($reaction->review->book)
                                    <small class="text-muted">par {{ $reaction->review->book->author ?? 'Auteur inconnu' }}</small>
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="text-muted small">Auteur de l'Avis</label>
                                <div class="fw-bold">{{ $reaction->review->user->name ?? 'N/A' }}</div>
                                @if($reaction->review->user)
                                    <small class="text-muted">{{ $reaction->review->user->email }}</small>
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="text-muted small">Note</label>
                                <div class="text-warning fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $reaction->review->rating ? '' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="text-dark ms-2">{{ $reaction->review->rating }}/5</span>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="text-muted small">Commentaire</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $reaction->review->comment ?? 'Pas de commentaire' }}
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="text-muted small">Statistiques de l'Avis</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="bg-success bg-opacity-10 p-2 rounded text-center">
                                            <div class="text-success fw-bold fs-4">
                                                {{ $reaction->review->reactions()->where('reaction_type', 'like')->count() }}
                                            </div>
                                            <small class="text-muted"><i class="fas fa-thumbs-up"></i> Likes</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded text-center">
                                            <div class="text-danger fw-bold fs-4">
                                                {{ $reaction->review->reactions()->where('reaction_type', 'dislike')->count() }}
                                            </div>
                                            <small class="text-muted"><i class="fas fa-thumbs-down"></i> Dislikes</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-info bg-opacity-10 p-2 rounded text-center">
                                            <div class="text-info fw-bold fs-4">
                                                {{ $reaction->review->reactions()->count() }}
                                            </div>
                                            <small class="text-muted"><i class="fas fa-hand-pointer"></i> Total</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded text-center">
                                            @php
                                                $totalReactions = $reaction->review->reactions()->count();
                                                $likes = $reaction->review->reactions()->where('reaction_type', 'like')->count();
                                                $ratio = $totalReactions > 0 ? ($likes / $totalReactions * 100) : 0;
                                            @endphp
                                            <div class="text-primary fw-bold fs-4">{{ number_format($ratio, 1) }}%</div>
                                            <small class="text-muted"><i class="fas fa-percentage"></i> Positif</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Avis non disponible
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Zone de Danger
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        La suppression de cette réaction est définitive et ne peut pas être annulée.
                    </p>
                    <form action="{{ route('admin.review-reactions.destroy', $reaction->id) }}" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette réaction ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer cette Réaction
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
