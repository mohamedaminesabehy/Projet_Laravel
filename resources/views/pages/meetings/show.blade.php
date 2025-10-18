@extends('layouts.app')

@section('title', 'Détails du Rendez-vous')

@section('content')
<style>
    .meeting-details-page {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .details-header {
        background: white;
        border-radius: 12px;
        padding: 20px 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .details-title {
        font-size: 24px;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }
    
    .status-badge {
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .status-proposed {
        background: #fff8e1;
        color: #f57f17;
    }
    
    .status-confirmed {
        background: #f8e8eb;
        color: #8b4951;
    }
    
    .status-completed {
        background: #e3f2fd;
        color: #1565c0;
    }
    
    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    
    .info-card h2 {
        font-size: 18px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 12px;
    }
    
    .info-card h2 i {
        color: #c9848f;
        font-size: 20px;
    }
    
    .participants-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .participant-card {
        background: linear-gradient(135deg, #c9848f 0%, #b67680 100%);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        color: white;
        box-shadow: 0 3px 10px rgba(201, 132, 143, 0.25);
    }
    
    .participant-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        margin: 0 auto 12px;
        border: 3px solid white;
    }
    
    .participant-name {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 6px;
    }
    
    .participant-email {
        font-size: 12px;
        opacity: 0.9;
        margin-bottom: 10px;
    }
    
    .participant-badge {
        background: rgba(255,255,255,0.3);
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .info-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        border-left: 3px solid #c9848f;
    }
    
    .info-item-icon {
        font-size: 20px;
        color: #c9848f;
        margin-bottom: 10px;
    }
    
    .info-item-label {
        font-size: 11px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    
    .info-item-value {
        font-size: 15px;
        color: #212529;
        font-weight: 600;
    }
    
    .books-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    }
    
    .book-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .book-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .book-title {
        font-size: 16px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 8px;
    }
    
    .book-author {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
    }
    
    .book-owner {
        font-size: 13px;
        color: #c9848f;
        font-weight: 600;
    }
    
    .notes-box {
        background: #fff8e1;
        border-left: 4px solid #fbc02d;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .notes-box p {
        color: #5d4037;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }
    
    .alert-danger-custom {
        background: #ffebee;
        border: 2px solid #ef5350;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .alert-danger-custom h4 {
        color: #c62828;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
    }
    
    .alert-danger-custom p {
        color: #d32f2f;
        margin: 0;
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 16px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #e0e0e0;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -31px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .timeline-marker.proposed { background: #9c27b0; }
    .timeline-marker.confirmed { background: #c9848f; }
    .timeline-marker.completed { background: #2196f3; }
    .timeline-marker.cancelled { background: #f44336; }
    
    .timeline-content {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
    }
    
    .timeline-title {
        font-size: 16px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 4px;
    }
    
    .timeline-date {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 3px;
    }
    
    .timeline-user {
        font-size: 12px;
        color: #c9848f;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn-action {
        flex: 1;
        min-width: 180px;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
        background: #6c5ce7;
        color: white;
    }
    
    .btn-complete:hover {
        background: #5f4dcd;
    }
    
    .btn-edit {
        background: #17a2b8;
        color: white;
    }
    
    .btn-edit:hover {
        background: #138496;
    }
    
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .book-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 16px;
        transition: all 0.3s;
    }
    
    .book-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        transform: translateY(-4px);
    }
    
    .book-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    
    .book-title {
        font-size: 16px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 6px;
    }
    
    .book-author {
        font-size: 14px;
        color: #6c757d;
    }
</style>

<div class="meeting-details-page">
<div class="container mx-auto px-4">
    <div class="max-w-5xl mx-auto">
        <!-- En-tête -->
        <div class="details-header">
            <h1 class="details-title">
                <i class="fas fa-calendar-check"></i> Détails du Rendez-vous
            </h1>
            @php
                $statusClasses = [
                    'proposed' => 'status-proposed',
                    'confirmed' => 'status-confirmed',
                    'completed' => 'status-completed',
                    'cancelled' => 'status-cancelled',
                ];
            @endphp
            <span class="status-badge {{ $statusClasses[$meeting->status] ?? '' }}">
                @if($meeting->status === 'proposed')
                    <i class="fas fa-clock"></i>
                @elseif($meeting->status === 'confirmed')
                    <i class="fas fa-check-circle"></i>
                @elseif($meeting->status === 'completed')
                    <i class="fas fa-flag-checkered"></i>
                @else
                    <i class="fas fa-times-circle"></i>
                @endif
                {{ $meeting->status_text }}
            </span>
        </div>

        <!-- Participants -->
        <div class="info-card">
            <h2><i class="fas fa-users"></i> Participants</h2>
            <div class="participants-grid">
                <div class="participant-card">
                    <div class="participant-avatar">
                        {{ substr($meeting->user1->name, 0, 1) }}
                    </div>
                    <div class="participant-name">{{ $meeting->user1->name }}</div>
                    <div class="participant-email">{{ $meeting->user1->email }}</div>
                    @if($meeting->proposed_by === $meeting->user1_id)
                        <span class="participant-badge">
                            <i class="fas fa-star"></i> Proposeur
                        </span>
                    @endif
                </div>
                <div class="participant-card">
                    <div class="participant-avatar">
                        {{ substr($meeting->user2->name, 0, 1) }}
                    </div>
                    <div class="participant-name">{{ $meeting->user2->name }}</div>
                    <div class="participant-email">{{ $meeting->user2->email }}</div>
                    @if($meeting->proposed_by === $meeting->user2_id)
                        <span class="participant-badge">
                            <i class="fas fa-star"></i> Proposeur
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations du rendez-vous -->
        <div class="info-card">
            <h2><i class="fas fa-info-circle"></i> Informations du Rendez-vous</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-item-label">Date</div>
                    <div class="info-item-value">{{ $meeting->meeting_date->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-item-label">Heure</div>
                    <div class="info-item-value">{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-item-label">Lieu</div>
                    <div class="info-item-value">{{ $meeting->meeting_place }}</div>
                </div>
                @if($meeting->meeting_address)
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-item-icon">
                        <i class="fas fa-location-arrow"></i>
                    </div>
                    <div class="info-item-label">Adresse complète</div>
                    <div class="info-item-value">{{ $meeting->meeting_address }}</div>
                </div>
                @endif
            </div>
            
            @if($meeting->notes)
            <div class="notes-box">
                <strong><i class="fas fa-sticky-note"></i> Notes :</strong><br>
                <p>{{ $meeting->notes }}</p>
            </div>
            @endif
            
            @if($meeting->status === 'cancelled' && $meeting->cancellation_reason)
            <div class="alert-danger-custom">
                <h4><i class="fas fa-exclamation-triangle"></i> Raison de l'annulation</h4>
                <p>{{ $meeting->cancellation_reason }}</p>
            </div>
            @endif
        </div>

        <!-- Livres concernés -->
        @if($meeting->book1 || $meeting->book2)
        <div class="info-card">
            <h2><i class="fas fa-book"></i> Livres concernés</h2>
            <div class="books-grid">
                @if($meeting->book1)
                <div class="book-card">
                    <img src="{{ $meeting->book1->cover_image ? asset('storage/' . $meeting->book1->cover_image) : asset('images/default-book.jpg') }}"
                         alt="{{ $meeting->book1->title }}"
                         class="book-cover">
                    <h3 class="book-title">{{ $meeting->book1->title }}</h3>
                    <p class="book-author">{{ $meeting->book1->author }}</p>
                </div>
                @endif
                @if($meeting->book2)
                <div class="book-card">
                    <img src="{{ $meeting->book2->cover_image ? asset('storage/' . $meeting->book2->cover_image) : asset('images/default-book.jpg') }}"
                         alt="{{ $meeting->book2->title }}"
                         class="book-cover">
                    <h3 class="book-title">{{ $meeting->book2->title }}</h3>
                    <p class="book-author">{{ $meeting->book2->author }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Historique -->
        <div class="info-card">
            <h2><i class="fas fa-history"></i> Historique</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker status-proposed-large"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Rendez-vous proposé</div>
                        <div class="timeline-date">{{ $meeting->proposed_at->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-user">Par {{ $meeting->proposedBy->name }}</div>
                    </div>
                </div>
                @if($meeting->confirmed_at)
                <div class="timeline-item">
                    <div class="timeline-marker status-confirmed-large"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Rendez-vous confirmé</div>
                        <div class="timeline-date">{{ $meeting->confirmed_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
                @endif
                @if($meeting->completed_at)
                <div class="timeline-item">
                    <div class="timeline-marker status-completed-large"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Rendez-vous terminé</div>
                        <div class="timeline-date">{{ $meeting->completed_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
                @endif
                @if($meeting->cancelled_at)
                <div class="timeline-item">
                    <div class="timeline-marker status-cancelled-large"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Rendez-vous annulé</div>
                        <div class="timeline-date">{{ $meeting->cancelled_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="action-buttons">
            @if($meeting->status === 'proposed' && $meeting->proposed_by !== Auth::id())
                <button onclick="confirmMeeting({{ $meeting->id }})" class="btn-action btn-confirm">
                    <i class="fas fa-check-circle"></i>Confirmer
                </button>
            @endif

            @if(in_array($meeting->status, ['proposed', 'confirmed']))
                <button onclick="cancelMeeting({{ $meeting->id }})" class="btn-action btn-cancel">
                    <i class="fas fa-times-circle"></i>Annuler
                </button>
            @endif

            @if($meeting->status === 'confirmed')
                <button onclick="completeMeeting({{ $meeting->id }})" class="btn-action btn-complete">
                    <i class="fas fa-flag-checkered"></i>Marquer terminé
                </button>
            @endif
            
            @if(in_array($meeting->status, ['proposed', 'confirmed']))
                <button onclick="editMeeting({{ $meeting->id }})" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>Modifier
                </button>
            @endif
        </div>
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
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.error || 'Erreur serveur');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert(error.message || 'Une erreur est survenue lors de la mise à jour');
    });
}

function editMeeting(meetingId) {
    // Rediriger vers la page d'édition
    window.location.href = `/meetings/${meetingId}/edit`;
}
</script>
@endsection
