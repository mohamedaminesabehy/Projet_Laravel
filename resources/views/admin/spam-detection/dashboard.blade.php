@extends('layouts.admin')

@section('title', 'Détection Spam par IA')

@push('styles')
<style>
    /* Forcer les couleurs du tableau */
    .table tbody td,
    .table tbody th {
        color: #333 !important;
        background-color: #fff !important;
    }
    
    .table thead th {
        color: #495057 !important;
        background-color: #f8f9fa !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    
    .message-preview {
        color: #333 !important;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">🤖 Détection Spam par IA</h1>
            <p class="text-muted">Système de Machine Learning - Hugging Face API</p>
        </div>
    </div>

    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistiques Globales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Messages Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Messages Bloqués
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['blocked'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bloqués Aujourd'hui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['today_blocked'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Taux de Blocage
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['block_rate'] }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique des derniers 7 jours -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Messages Bloqués - 7 Derniers Jours
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="spamChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des Messages Bloqués -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fas fa-shield-alt"></i> Messages Bloqués par l'IA ({{ $blockedMessages->total() }})
            </h6>
        </div>
        <div class="card-body">
            @if($blockedMessages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="color: #333;">
                        <thead class="thead-light" style="background-color: #f8f9fa;">
                            <tr style="color: #495057;">
                                <th width="5%">ID</th>
                                <th width="15%">Expéditeur</th>
                                <th width="15%">Destinataire</th>
                                <th width="30%">Message</th>
                                <th width="10%">Score IA</th>
                                <th width="15%">Date Blocage</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blockedMessages as $message)
                                <tr style="color: #333; background-color: #fff;">
                                    <td style="color: #333;">{{ $message->id }}</td>
                                    <td style="color: #333;">
                                        @if($message->sender)
                                            <strong>{{ $message->sender->first_name }} {{ $message->sender->last_name }}</strong><br>
                                            <small class="text-muted">ID: {{ $message->sender->id }}</small>
                                        @else
                                            <span class="text-muted">Inconnu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($message->receiver)
                                            {{ $message->receiver->first_name }} {{ $message->receiver->last_name }}
                                        @else
                                            <span class="text-muted">Inconnu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="message-preview" style="max-height: 60px; overflow: hidden;">
                                            {{ Str::limit($message->contenu ?? 'Contenu supprimé', 100) }}
                                        </div>
                                        @if($message->spam_reasons)
                                            <button class="btn btn-sm btn-outline-info mt-2" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#reasonsModal{{ $message->id }}">
                                                <i class="fas fa-info-circle"></i> Voir raisons
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $message->spam_score >= 90 ? 'danger' : ($message->spam_score >= 70 ? 'warning' : 'info') }} badge-pill" 
                                              style="font-size: 14px;">
                                            {{ $message->spam_score }}%
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $message->blocked_at ? $message->blocked_at->format('d/m/Y H:i') : 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <form action="{{ route('admin.spam.unblock', $message->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mb-1" title="Débloquer">
                                                    <i class="fas fa-unlock"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.spam.delete', $message->id) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Supprimer définitivement ce message ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-1" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal pour afficher les raisons détaillées -->
                                @if($message->spam_reasons)
                                    <div class="modal fade" id="reasonsModal{{ $message->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle"></i> 
                                                        Raisons de Détection (Score: {{ $message->spam_score }}%)
                                                    </h5>
                                                    <button type="button" class="close text-white" data-bs-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Message analysé :</h6>
                                                    <div class="alert alert-secondary">
                                                        {{ $message->contenu ?? 'Contenu supprimé' }}
                                                    </div>

                                                    <h6 class="mt-3">Détections de l'IA :</h6>
                                                    <ul class="list-group">
                                                        @foreach(json_decode($message->spam_reasons, true) as $reason)
                                                            <li class="list-group-item">
                                                                <i class="fas fa-arrow-right text-danger"></i> {{ $reason }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $blockedMessages->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5>Aucun message bloqué</h5>
                    <p class="text-muted">L'IA n'a détecté aucun spam pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Graphique des spam par jour
    const ctx = document.getElementById('spamChart').getContext('2d');
    const dailyData = @json($dailyStats);
    
    const labels = dailyData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short' });
    }).reverse();
    
    const data = dailyData.map(item => item.count).reverse();
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Messages Bloqués',
                data: data,
                borderColor: 'rgb(220, 53, 69)',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
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
                        stepSize: 1
                    }
                }
            }
        }
    });
    
    // Initialiser les modals Bootstrap 5
    document.addEventListener('DOMContentLoaded', function() {
        // Assurer que les modals fonctionnent
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modalElement => {
            if (typeof bootstrap !== 'undefined') {
                new bootstrap.Modal(modalElement);
            }
        });
    });
</script>
@endpush
@endsection
