@extends('layouts.admin')

@section('title', 'Détails du Rendez-vous')

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
    
    .card-header {
        background-color: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .card-header h5 {
        color: #1a202c !important;
        font-weight: 700;
    }
    
    .font-weight-bold {
        color: #2d3748 !important;
        font-weight: 700 !important;
    }
    
    .card-body p {
        color: #2d3748 !important;
        font-weight: 500;
    }
    
    .badge {
        font-size: 14px;
        font-weight: 600;
        padding: 8px 16px;
    }
    
    .badge-warning {
        background-color: #fbbf24;
        color: #78350f;
    }
    
    .badge-success {
        background-color: #c9848f;
        color: white;
    }
    
    .badge-info {
        background-color: #60a5fa;
        color: white;
    }
    
    .badge-danger {
        background-color: #f87171;
        color: white;
    }
    
    .btn-primary {
        background-color: #c9848f;
        border-color: #c9848f;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background-color: #b67680;
        border-color: #b67680;
    }
    
    .bg-light {
        background-color: #f7fafc !important;
    }
    
    .border-left-primary {
        border-left: 4px solid #c9848f !important;
    }
    
    .text-primary {
        color: #c9848f !important;
    }
    
    .list-group-item {
        color: #2d3748 !important;
        font-weight: 500;
    }
    
    .list-group-item i {
        color: #c9848f !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-alt"></i> Détails du Rendez-vous #{{ $meeting->id }}
        </h1>
        <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du Rendez-vous</h6>
                </div>
                <div class="card-body">
                    <!-- Statut -->
                    <div class="mb-4">
                        @php
                            $badges = [
                                'proposed' => 'warning',
                                'confirmed' => 'success',
                                'completed' => 'info',
                                'cancelled' => 'danger',
                            ];
                        @endphp
                        <span class="badge badge-{{ $badges[$meeting->status] ?? 'secondary' }} badge-lg" style="font-size: 16px; padding: 10px 20px;">
                            {{ $meeting->status_text }}
                        </span>
                    </div>

                    <!-- Date et heure -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold"><i class="fas fa-calendar mr-2 text-primary"></i>Date</label>
                            <p class="mb-0">{{ $meeting->meeting_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold"><i class="fas fa-clock mr-2 text-primary"></i>Heure</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    <!-- Lieu -->
                    <div class="mb-3">
                        <label class="font-weight-bold"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Lieu</label>
                        <p class="mb-0">{{ $meeting->meeting_place }}</p>
                        @if($meeting->meeting_address)
                            <p class="text-muted small mb-0">{{ $meeting->meeting_address }}</p>
                        @endif
                    </div>

                    <!-- Notes -->
                    @if($meeting->notes)
                    <div class="mb-3">
                        <label class="font-weight-bold"><i class="fas fa-sticky-note mr-2 text-primary"></i>Notes</label>
                        <p class="mb-0">{{ $meeting->notes }}</p>
                    </div>
                    @endif

                    <!-- Raison d'annulation -->
                    @if($meeting->status === 'cancelled' && $meeting->cancellation_reason)
                    <div class="alert alert-danger">
                        <label class="font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Raison d'annulation</label>
                        <p class="mb-0">{{ $meeting->cancellation_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Participants -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Participants</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="mb-2">{{ $meeting->user1->name }}</h6>
                                <p class="mb-1 text-muted small"><i class="fas fa-envelope mr-2"></i>{{ $meeting->user1->email }}</p>
                                @if($meeting->proposed_by === $meeting->user1_id)
                                    <span class="badge badge-purple">Proposeur</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="mb-2">{{ $meeting->user2->name }}</h6>
                                <p class="mb-1 text-muted small"><i class="fas fa-envelope mr-2"></i>{{ $meeting->user2->email }}</p>
                                @if($meeting->proposed_by === $meeting->user2_id)
                                    <span class="badge badge-purple">Proposeur</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livres -->
            @if($meeting->book1 || $meeting->book2)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Livres concernés</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($meeting->book1)
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                @if($meeting->book1->cover_image)
                                    <img src="{{ asset('storage/' . $meeting->book1->cover_image) }}" 
                                         alt="{{ $meeting->book1->title }}" 
                                         class="img-fluid mb-3" 
                                         style="max-height: 200px;">
                                @endif
                                <h6>{{ $meeting->book1->title }}</h6>
                                <p class="text-muted small mb-0">{{ $meeting->book1->author }}</p>
                                <p class="text-muted small">Propriétaire: {{ $meeting->book1->user?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @endif
                        @if($meeting->book2)
                        <div class="col-md-6">
                            <div class="border rounded p-3 text-center">
                                @if($meeting->book2->cover_image)
                                    <img src="{{ asset('storage/' . $meeting->book2->cover_image) }}" 
                                         alt="{{ $meeting->book2->title }}" 
                                         class="img-fluid mb-3" 
                                         style="max-height: 200px;">
                                @endif
                                <h6>{{ $meeting->book2->title }}</h6>
                                <p class="text-muted small mb-0">{{ $meeting->book2->author }}</p>
                                <p class="text-muted small">Propriétaire: {{ $meeting->book2->user?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Historique et Actions -->
        <div class="col-lg-4">
            <!-- Historique -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historique</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="fas fa-plus-circle text-purple mr-2"></i>
                            <strong>Proposé</strong><br>
                            <small class="text-muted">{{ $meeting->proposed_at->format('d/m/Y à H:i') }}</small><br>
                            <small class="text-muted">Par: {{ $meeting->proposedBy->name }}</small>
                        </li>
                        @if($meeting->confirmed_at)
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Confirmé</strong><br>
                            <small class="text-muted">{{ $meeting->confirmed_at->format('d/m/Y à H:i') }}</small>
                        </li>
                        @endif
                        @if($meeting->completed_at)
                        <li class="mb-3">
                            <i class="fas fa-flag-checkered text-info mr-2"></i>
                            <strong>Terminé</strong><br>
                            <small class="text-muted">{{ $meeting->completed_at->format('d/m/Y à H:i') }}</small>
                        </li>
                        @endif
                        @if($meeting->cancelled_at)
                        <li class="mb-3">
                            <i class="fas fa-times-circle text-danger mr-2"></i>
                            <strong>Annulé</strong><br>
                            <small class="text-muted">{{ $meeting->cancelled_at->format('d/m/Y à H:i') }}</small>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Message lié -->
            @if($meeting->message)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Message d'origine</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>De:</strong> {{ $meeting->message->sender->name }}</p>
                    <p class="mb-2"><strong>À:</strong> {{ $meeting->message->receiver->name }}</p>
                    <p class="mb-2"><strong>Date:</strong> {{ \Carbon\Carbon::parse($meeting->message->date_envoi)->format('d/m/Y H:i') }}</p>
                    <div class="border-top pt-2 mt-2">
                        <p class="mb-0 text-muted small">{{ Str::limit($meeting->message->contenu, 100) }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions Admin -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions Administrateur</h6>
                </div>
                <div class="card-body">
                    @if(in_array($meeting->status, ['proposed', 'confirmed']))
                        <button onclick="cancelMeeting({{ $meeting->id }})" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-ban"></i> Annuler le rendez-vous
                        </button>
                    @endif
                    <button onclick="deleteMeeting({{ $meeting->id }})" class="btn btn-danger btn-block">
                        <i class="fas fa-trash"></i> Supprimer définitivement
                    </button>
                </div>
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    });
}

function deleteMeeting(meetingId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer définitivement ce rendez-vous ? Cette action est irréversible.')) return;

    fetch(`/admin/meetings/${meetingId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '/admin/meetings';
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    });
}
</script>

<style>
.badge-purple {
    background-color: #6f42c1;
    color: white;
}
.badge-lg {
    font-size: 1rem !important;
    padding: 0.5rem 1rem !important;
}
</style>
@endsection
