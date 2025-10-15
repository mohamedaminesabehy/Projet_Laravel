<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserTrustScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trust_score',
        'successful_exchanges',
        'cancelled_meetings',
        'messages_sent',
        'messages_received',
        'reviews_given',
        'reviews_received',
        'account_age_days',
        'is_verified',
        'verification_date',
        'last_suspicious_activity',
        'last_suspicious_at',
        'score_history',
        'last_calculated_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verification_date' => 'datetime',
        'last_suspicious_at' => 'datetime',
        'last_calculated_at' => 'datetime',
        'score_history' => 'array',
    ];

    /**
     * Relation : Un score appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculer le score de confiance basé sur l'IA
     * 
     * Algorithme de calcul :
     * - Score de base : 50 points
     * - Échanges réussis : +5 points par échange (max +30)
     * - Annulations de RDV : -10 points par annulation (max -30)
     * - Messages actifs : +10 points si > 20 messages (max +10)
     * - Avis reçus : +5 points par avis positif (max +20)
     * - Ancienneté : +10 points si > 30 jours (max +10)
     * - Pénalité activité suspecte : -20 points
     */
    public function calculateTrustScore()
    {
        $score = 50; // Score de base

        // 1. Échanges réussis (+5 points chacun, max +30)
        $exchangePoints = min($this->successful_exchanges * 5, 30);
        $score += $exchangePoints;

        // 2. Annulations de RDV (-10 points chacune, max -30)
        $cancellationPenalty = min($this->cancelled_meetings * 10, 30);
        $score -= $cancellationPenalty;

        // 3. Activité de messagerie (+10 points si actif)
        $totalMessages = $this->messages_sent + $this->messages_received;
        if ($totalMessages > 20) {
            $score += 10;
        }

        // 4. Avis reçus (+5 points par avis, max +20)
        $reviewPoints = min($this->reviews_received * 5, 20);
        $score += $reviewPoints;

        // 5. Ancienneté du compte (+10 points si > 30 jours)
        if ($this->account_age_days > 30) {
            $score += 10;
        } elseif ($this->account_age_days > 7) {
            $score += 5;
        }

        // 6. Pénalité pour activité suspecte
        if ($this->last_suspicious_activity) {
            $score -= 20;
        }

        // S'assurer que le score reste entre 0 et 100
        $score = max(0, min(100, $score));

        // Mettre à jour le score
        $this->trust_score = $score;
        $this->last_calculated_at = now();

        // Mettre à jour le statut de vérification
        $this->is_verified = $score >= 80;
        if ($this->is_verified && !$this->verification_date) {
            $this->verification_date = now();
        } elseif (!$this->is_verified) {
            $this->verification_date = null;
        }

        // Ajouter à l'historique
        $this->addToHistory($score);

        $this->save();

        return $score;
    }

    /**
     * Ajouter le score à l'historique
     */
    protected function addToHistory($score)
    {
        $history = $this->score_history ?? [];
        
        $history[] = [
            'score' => $score,
            'date' => now()->toDateTimeString(),
        ];

        // Garder seulement les 30 derniers scores
        if (count($history) > 30) {
            $history = array_slice($history, -30);
        }

        $this->score_history = $history;
    }

    /**
     * Obtenir le badge de couleur selon le score
     */
    public function getBadgeColorAttribute()
    {
        if ($this->trust_score >= 80) {
            return 'success'; // Vert
        } elseif ($this->trust_score >= 60) {
            return 'warning'; // Orange
        } else {
            return 'danger'; // Rouge
        }
    }

    /**
     * Obtenir le texte du badge
     */
    public function getBadgeTextAttribute()
    {
        if ($this->is_verified) {
            return 'Utilisateur Vérifié ✓';
        } elseif ($this->trust_score >= 60) {
            return 'Utilisateur Standard';
        } else {
            return 'Utilisateur Nouveau';
        }
    }

    /**
     * Obtenir le niveau de confiance en texte
     */
    public function getTrustLevelAttribute()
    {
        if ($this->trust_score >= 90) {
            return 'Excellent';
        } elseif ($this->trust_score >= 80) {
            return 'Très bon';
        } elseif ($this->trust_score >= 60) {
            return 'Bon';
        } elseif ($this->trust_score >= 40) {
            return 'Moyen';
        } else {
            return 'Faible';
        }
    }

    /**
     * Vérifier si l'utilisateur est suspect
     */
    public function isSuspicious()
    {
        return $this->trust_score < 40 || 
               $this->cancelled_meetings > 5 || 
               $this->last_suspicious_activity !== null;
    }

    /**
     * Signaler une activité suspecte
     */
    public function reportSuspiciousActivity($reason)
    {
        $this->last_suspicious_activity = $reason;
        $this->last_suspicious_at = now();
        $this->save();

        // Recalculer le score
        $this->calculateTrustScore();
    }

    /**
     * Scope : Utilisateurs vérifiés
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope : Utilisateurs suspects
     */
    public function scopeSuspicious($query)
    {
        return $query->where('trust_score', '<', 40)
                    ->orWhereNotNull('last_suspicious_activity');
    }

    /**
     * Scope : Score minimum
     */
    public function scopeMinScore($query, $score)
    {
        return $query->where('trust_score', '>=', $score);
    }
}
