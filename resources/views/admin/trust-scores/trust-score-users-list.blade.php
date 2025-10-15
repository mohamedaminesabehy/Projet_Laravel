@extends('layouts.admin')

@section('title', 'Scores de Confiance - Liste des Utilisateurs')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .trust-filter-card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    .trust-table-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .trust-score-badge {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
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
    .trust-filter-btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .trust-table-row:hover {
        background-color: #f0f8ff;
        transition: all 0.3s ease;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-users text-primary"></i> Liste des Utilisateurs - Scores de Confiance
            </h1>
            <p class="text-muted mb-0">{{ $users->total() }} utilisateurs trouvés</p>
        </div>
        <div>
            <a href="{{ route('admin.trust-scores.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard
            </a>
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

    <!-- Filtres -->
    <div class="card trust-filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.trust-scores.users') }}" class="row">
                <div class="col-md-4 mb-3">
                    <label for="search" class="form-label">
                        <i class="fas fa-search"></i> Rechercher
                    </label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Nom, prénom, email..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="filter" class="form-label">
                        <i class="fas fa-filter"></i> Filtrer par
                    </label>
                    <select name="filter" id="filter" class="form-control">
                        <option value="">Tous les utilisateurs</option>
                        <option value="verified" {{ request('filter') == 'verified' ? 'selected' : '' }}>
                            Vérifiés (≥80)
                        </option>
                        <option value="excellent" {{ request('filter') == 'excellent' ? 'selected' : '' }}>
                            Excellent (≥90)
                        </option>
                        <option value="good" {{ request('filter') == 'good' ? 'selected' : '' }}>
                            Bon (60-89)
                        </option>
                        <option value="low" {{ request('filter') == 'low' ? 'selected' : '' }}>
                            Faible (<60)
                        </option>
                        <option value="suspicious" {{ request('filter') == 'suspicious' ? 'selected' : '' }}>
                            Suspects
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="sort" class="form-label">
                        <i class="fas fa-sort"></i> Trier par
                    </label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="trust_score" {{ request('sort') == 'trust_score' ? 'selected' : '' }}>
                            Score
                        </option>
                        <option value="successful_exchanges" {{ request('sort') == 'successful_exchanges' ? 'selected' : '' }}>
                            Échanges
                        </option>
                        <option value="account_age_days" {{ request('sort') == 'account_age_days' ? 'selected' : '' }}>
                            Âge du compte
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="dir" class="form-label">Ordre</label>
                    <select name="dir" id="dir" class="form-control">
                        <option value="desc" {{ request('dir') == 'desc' ? 'selected' : '' }}>
                            Décroissant
                        </option>
                        <option value="asc" {{ request('dir') == 'asc' ? 'selected' : '' }}>
                            Croissant
                        </option>
                    </select>
                </div>

                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="card trust-table-card">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-table"></i> Liste des Utilisateurs
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="80">Score</th>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th width="120">Statut</th>
                            <th width="100" class="text-center">Échanges</th>
                            <th width="100" class="text-center">Annulations</th>
                            <th width="100" class="text-center">Messages</th>
                            <th width="100" class="text-center">Âge (jours)</th>
                            <th width="180" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $trustScore)
                        <tr class="trust-table-row">
                            <td>
                                <div class="trust-score-badge 
                                    @if($trustScore->trust_score >= 90) trust-score-excellent
                                    @elseif($trustScore->trust_score >= 80) trust-score-good
                                    @elseif($trustScore->trust_score >= 60) trust-score-medium
                                    @else trust-score-low
                                    @endif">
                                    {{ $trustScore->trust_score }}
                                </div>
                            </td>
                            <td>
                                <strong>{{ $trustScore->user->first_name }} {{ $trustScore->user->last_name }}</strong>
                                <br>
                                <small class="badge 
                                    @if($trustScore->trust_score >= 90) badge-success
                                    @elseif($trustScore->trust_score >= 60) badge-info
                                    @else badge-warning
                                    @endif">
                                    {{ $trustScore->trust_level }}
                                </small>
                            </td>
                            <td>
                                <small>{{ $trustScore->user->email }}</small>
                            </td>
                            <td>
                                @if($trustScore->is_verified)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Vérifié
                                </span>
                                @elseif($trustScore->isSuspicious())
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Suspect
                                </span>
                                @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-user"></i> Standard
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $trustScore->successful_exchanges }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-danger">{{ $trustScore->cancelled_meetings }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ $trustScore->messages_sent + $trustScore->messages_received }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $trustScore->account_age_days }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.trust-scores.show', $trustScore->user->id) }}" 
                                       class="btn btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.trust-scores.recalculate', $trustScore->user->id) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" title="Recalculer">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Aucun utilisateur trouvé.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
