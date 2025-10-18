<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user1_id',
        'user2_id',
        'book1_id',
        'book2_id',
        'meeting_date',
        'meeting_time',
        'meeting_place',
        'meeting_address',
        'status',
        'notes',
        'proposed_by',
        'proposed_at',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'proposed_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relation avec le message qui a déclenché le rendez-vous
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Premier utilisateur du rendez-vous
     */
    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    /**
     * Deuxième utilisateur du rendez-vous
     */
    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    /**
     * Premier livre concerné par l'échange
     */
    public function book1()
    {
        return $this->belongsTo(Book::class, 'book1_id');
    }

    /**
     * Deuxième livre concerné par l'échange
     */
    public function book2()
    {
        return $this->belongsTo(Book::class, 'book2_id');
    }

    /**
     * Utilisateur qui a proposé le rendez-vous
     */
    public function proposedBy()
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour les rendez-vous proposés
     */
    public function scopeProposed($query)
    {
        return $query->where('status', 'proposed');
    }

    /**
     * Scope pour les rendez-vous confirmés
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope pour les rendez-vous complétés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les rendez-vous annulés
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope pour les rendez-vous d'un utilisateur
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user1_id', $userId)
                    ->orWhere('user2_id', $userId);
    }

    /**
     * Scope pour les rendez-vous à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('meeting_date', '>=', now()->toDateString())
                    ->whereIn('status', ['proposed', 'confirmed']);
    }

    /**
     * Scope pour les rendez-vous passés
     */
    public function scopePast($query)
    {
        return $query->where('meeting_date', '<', now()->toDateString())
                    ->whereIn('status', ['completed', 'cancelled']);
    }

    /**
     * Vérifie si l'utilisateur fait partie du rendez-vous
     */
    public function involvesUser($userId)
    {
        return $this->user1_id == $userId || $this->user2_id == $userId;
    }

    /**
     * Obtient l'autre utilisateur dans le rendez-vous
     */
    public function getOtherUser($currentUserId)
    {
        if ($this->user1_id == $currentUserId) {
            return $this->user2;
        }
        return $this->user1;
    }

    /**
     * Vérifie si le rendez-vous peut être confirmé
     */
    public function canBeConfirmed()
    {
        return $this->status === 'proposed';
    }

    /**
     * Vérifie si le rendez-vous peut être annulé
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['proposed', 'confirmed']);
    }

    /**
     * Vérifie si le rendez-vous peut être marqué comme complété
     */
    public function canBeCompleted()
    {
        // On peut marquer comme complété si le statut est confirmé
        // Plus besoin de vérifier la date - l'utilisateur peut décider
        return $this->status === 'confirmed';
    }

    /**
     * Formatte la date et l'heure pour l'affichage
     */
    public function getFormattedDateTimeAttribute()
    {
        return $this->meeting_date->format('d/m/Y') . ' à ' . $this->meeting_time;
    }

    /**
     * Obtient un badge de couleur selon le statut
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'proposed' => '<span class="badge bg-warning">Proposé</span>',
            'confirmed' => '<span class="badge bg-success">Confirmé</span>',
            'completed' => '<span class="badge bg-info">Terminé</span>',
            'cancelled' => '<span class="badge bg-danger">Annulé</span>',
            default => '<span class="badge bg-secondary">Inconnu</span>',
        };
    }

    /**
     * Obtient le texte du statut en français
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'proposed' => 'Proposé',
            'confirmed' => 'Confirmé',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            default => 'Inconnu',
        };
    }
}
