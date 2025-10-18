@extends('layouts.app')

@section('title', 'Mes Rendez-vous')

@section('content')
<style>
    .meetings-container {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .meetings-header {
        margin-bottom: 30px;
    }
    
    .meetings-title {
        font-size: 32px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 20px;
    }
    
    .btn-back {
        background: #c9848f;
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s;
    }
    
    .btn-back:hover {
        background: #b67680;
        color: white;
    }
    
    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .tabs-nav {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 30px;
    }
    
    .tab-link {
        padding: 12px 20px;
        text-decoration: none;
        color: #6c757d;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }
    
    .tab-link:hover {
        color: #495057;
    }
    
    .tab-link.active {
        color: #c9848f;
        border-bottom-color: #c9848f;
    }
    
    .empty-state {
        background: white;
        padding: 60px 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .empty-state i {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
    }
    
    .empty-state p {
        color: #6c757d;
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .empty-state a {
        color: #c9848f;
        text-decoration: none;
    }
    
    .meeting-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s;
    }
    
    .meeting-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .meeting-header {
        margin-bottom: 16px;
    }
    
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-proposed {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-confirmed {
        background: #f8e8eb;
        color: #8b4951;
    }
    
    .status-completed {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .meeting-title {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 12px 0;
    }
    
    .meeting-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }
    
    .meeting-detail-item {
        display: flex;
        align-items: center;
        color: #495057;
    }
    
    .meeting-detail-item i {
        color: #c9848f;
        margin-right: 8px;
        font-size: 16px;
    }
    
    .meeting-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
    }
    
    .btn-details {
        background: #c9848f;
        color: white;
    }
    
    .btn-details:hover {
        background: #b67680;
        color: white;
    }
    
    .btn-confirm {
        background: #c9848f;
        color: white;
    }
    
    .btn-confirm:hover {
        background: #b67680;
    }
    
    .btn-cancel {
        background: #dc3545;
        color: white;
    }
    
    .btn-cancel:hover {
        background: #c82333;
    }
    
    .btn-complete {
        background: #6f42c1;
        color: white;
    }
    
    .btn-complete:hover {
        background: #5a32a3;
    }
</style>

<div class="meetings-container">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- En-tête -->
        <div class="meetings-header mb-4">
            <h1 class="meetings-title">Mes Rendez-vous</h1>
        </div>

        <!-- Alertes de succès -->
        @if(session('success'))
        <div class="alert-success" role="alert">
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Onglets de filtrage -->
        <div class="tabs-nav d-flex" style="gap: 20px;">
            <a href="?status=all" class="tab-link {{ request('status', 'all') === 'all' ? 'active' : '' }}">
                Tous
            </a>
            <a href="?status=proposed" class="tab-link {{ request('status') === 'proposed' ? 'active' : '' }}">
                Proposés
            </a>
            <a href="?status=confirmed" class="tab-link {{ request('status') === 'confirmed' ? 'active' : '' }}">
                Confirmés
            </a>
            <a href="?status=completed" class="tab-link {{ request('status') === 'completed' ? 'active' : '' }}">
                Terminés
            </a>
            <a href="?status=cancelled" class="tab-link {{ request('status') === 'cancelled' ? 'active' : '' }}">
                Annulés
            </a>
        </div>

        <!-- Liste des rendez-vous -->
        @if($meetings->isEmpty())
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>Aucun rendez-vous pour le moment.</p>
                <a href="{{ route('pages.messages') }}">
                    Proposer un rendez-vous depuis vos messages
                </a>
            </div>
        @else
            <div class="meetings-list">
                @foreach($meetings as $meeting)
                    <div class="meeting-card">
                        <div class="meeting-header">
                            <!-- Badge de statut -->
                            @php
                                $statusClasses = [
                                    'proposed' => 'status-proposed',
                                    'confirmed' => 'status-confirmed',
                                    'completed' => 'status-completed',
                                    'cancelled' => 'status-cancelled',
                                ];
                            @endphp
                            <span class="status-badge {{ $statusClasses[$meeting->status] ?? '' }}">
                                {{ $meeting->status_text }}
                            </span>
                            
                            @if($meeting->proposed_by === Auth::id())
                                <span class="text-muted small ml-2">(Vous avez proposé)</span>
                            @endif
                        </div>

                        <h3 class="meeting-title">
                            Rendez-vous avec {{ $meeting->getOtherUser(Auth::id())->name }}
                        </h3>

                        <div class="meeting-details">
                            <div class="meeting-detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $meeting->meeting_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="meeting-detail-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}</span>
                            </div>
                            <div class="meeting-detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $meeting->meeting_place }}</span>
                            </div>
                            @if($meeting->book1 || $meeting->book2)
                                <div class="meeting-detail-item">
                                    <i class="fas fa-book"></i>
                                    <span>
                                        @if($meeting->book1){{ $meeting->book1->title }}@endif
                                        @if($meeting->book1 && $meeting->book2) ↔ @endif
                                        @if($meeting->book2){{ $meeting->book2->title }}@endif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="meeting-actions">
                            <a href="{{ route('meetings.show', $meeting->id) }}" class="btn-action btn-details">
                                <i class="fas fa-eye"></i>Détails
                            </a>

                            @if($meeting->status === 'proposed' && $meeting->proposed_by !== Auth::id())
                                <button onclick="confirmMeeting({{ $meeting->id }})" class="btn-action btn-confirm">
                                    <i class="fas fa-check"></i>Confirmer
                                </button>
                            @endif

                            @if(in_array($meeting->status, ['proposed', 'confirmed']))
                                <button onclick="cancelMeeting({{ $meeting->id }})" class="btn-action btn-cancel">
                                    <i class="fas fa-times"></i>Annuler
                                </button>
                            @endif

                            @if($meeting->status === 'confirmed' && $meeting->meeting_date <= now()->toDateString())
                                <button onclick="completeMeeting({{ $meeting->id }})" class="btn-action btn-complete">
                                    <i class="fas fa-check-circle"></i>Terminer
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $meetings->links() }}
            </div>
        @endif
    </div>
</div>
</div>

<script>
function confirmMeeting(meetingId) {
    if (!confirm('Voulez-vous confirmer ce rendez-vous ?')) return;

    fetch(`/meetings/${meetingId}/confirm`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
}

function cancelMeeting(meetingId) {
    const reason = prompt('Raison de l\'annulation (optionnel) :');
    if (reason === null) return;

    fetch(`/meetings/${meetingId}/cancel`, {
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
}

function completeMeeting(meetingId) {
    if (!confirm('Marquer ce rendez-vous comme terminé ?')) return;

    fetch(`/meetings/${meetingId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
}
</script>
@endsection
