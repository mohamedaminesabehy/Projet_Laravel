@extends('layouts.admin')

@section('title', 'Gestion des Rendez-vous')

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
    
    label {
        color: #2d3748 !important;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-control {
        color: #1a202c !important;
        border: 2px solid #e2e8f0;
    }
    
    .form-control:focus {
        border-color: #c9848f;
        box-shadow: 0 0 0 0.2rem rgba(201, 132, 143, 0.25);
    }
    
    .table thead th {
        color: #1a202c !important;
        font-weight: 700;
        background-color: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table tbody td {
        color: #2d3748 !important;
        font-weight: 500;
        vertical-align: middle;
    }
    
    .badge {
        font-size: 13px;
        font-weight: 600;
        padding: 6px 12px;
    }
    
    .btn {
        font-weight: 600;
    }
    
    .btn-primary {
        background-color: #c9848f;
        border-color: #c9848f;
    }
    
    .btn-primary:hover {
        background-color: #b67680;
        border-color: #b67680;
    }
    
    .border-left-primary {
        border-left: 4px solid #c9848f !important;
    }
    
    .text-primary {
        color: #c9848f !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Rendez-vous</h1>
        <div>
            <a href="{{ route('admin.meetings.dashboard') }}" class="btn btn-info">
                <i class="fas fa-chart-bar"></i> Statistiques
            </a>
            <a href="{{ route('admin.meetings.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> CSV
            </a>
            <a href="{{ route('admin.meetings.export.pdf', request()->query()) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
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
    </div>

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.meetings.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label>Statut</label>
                        <select name="status" class="form-control">
                            <option value="">Tous</option>
                            <option value="proposed" {{ request('status') === 'proposed' ? 'selected' : '' }}>Proposés</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmés</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminés</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulés</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Date de début</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Date de fin</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Rechercher</label>
                        <input type="text" name="search" class="form-control" placeholder="Nom d'utilisateur" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table des rendez-vous -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Rendez-vous</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date/Heure</th>
                            <th>Utilisateurs</th>
                            <th>Lieu</th>
                            <th>Livres</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meetings as $meeting)
                            <tr>
                                <td>{{ $meeting->id }}</td>
                                <td>
                                    {{ $meeting->meeting_date->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $meeting->user1->name }}</strong><br>
                                    <small>↔</small><br>
                                    <strong>{{ $meeting->user2->name }}</strong>
                                </td>
                                <td>{{ Str::limit($meeting->meeting_place, 30) }}</td>
                                <td>
                                    @if($meeting->book1)
                                        {{ Str::limit($meeting->book1->title, 20) }}
                                    @endif
                                    @if($meeting->book1 && $meeting->book2)
                                        <br><small>↔</small><br>
                                    @endif
                                    @if($meeting->book2)
                                        {{ Str::limit($meeting->book2->title, 20) }}
                                    @endif
                                    @if(!$meeting->book1 && !$meeting->book2)
                                        <em class="text-muted">Aucun</em>
                                    @endif
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <a href="{{ route('admin.meetings.show', $meeting->id) }}" class="btn btn-sm btn-info" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array($meeting->status, ['proposed', 'confirmed']))
                                        <button onclick="cancelMeeting({{ $meeting->id }})" class="btn btn-sm btn-warning" title="Annuler">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteMeeting({{ $meeting->id }})" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun rendez-vous trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $meetings->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function cancelMeeting(meetingId) {
    const reason = prompt('Raison de l\'annulation (Admin) :');
    if (!reason) return;

    fetch(`/admin/meetings/${meetingId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ cancellation_reason: reason })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message || 'Rendez-vous annulé avec succès');
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'annulation du rendez-vous');
    });
}

function deleteMeeting(meetingId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer définitivement ce rendez-vous ?\n\nCette action est irréversible !')) {
        return;
    }

    // Vérifier que le token CSRF existe
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('Erreur: Token CSRF manquant');
        return;
    }

    fetch(`/admin/meetings/${meetingId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message || 'Rendez-vous supprimé avec succès');
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue lors de la suppression');
        }
    })
    .catch(error => {
        console.error('Erreur complète:', error);
        alert('Erreur lors de la suppression du rendez-vous: ' + error.message);
    });
}
</script>
@endsection
