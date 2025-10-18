<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTrustScore;
use App\Models\Meeting;
use App\Models\Message;
use Carbon\Carbon;

class TrustScoreService
{
    /**
     * Calculer ou mettre à jour le score de confiance d'un utilisateur
     * 
     * @param User $user
     * @return UserTrustScore
     */
    public function calculateUserTrustScore(User $user)
    {
        // Récupérer ou créer le score
        $trustScore = $user->trustScore ?? UserTrustScore::create(['user_id' => $user->id]);

        // Collecter les métriques
        $metrics = $this->collectUserMetrics($user);

        // Mettre à jour les métriques
        $trustScore->successful_exchanges = $metrics['successful_exchanges'];
        $trustScore->cancelled_meetings = $metrics['cancelled_meetings'];
        $trustScore->messages_sent = $metrics['messages_sent'];
        $trustScore->messages_received = $metrics['messages_received'];
        $trustScore->reviews_given = $metrics['reviews_given'];
        $trustScore->reviews_received = $metrics['reviews_received'];
        $trustScore->account_age_days = $metrics['account_age_days'];

        $trustScore->save();

        // Calculer le score avec l'algorithme IA
        $trustScore->calculateTrustScore();

        // Détecter les comportements suspects
        $this->detectSuspiciousBehavior($user, $trustScore);

        return $trustScore;
    }

    /**
     * Collecter toutes les métriques d'un utilisateur
     * 
     * @param User $user
     * @return array
     */
    protected function collectUserMetrics(User $user)
    {
        return [
            // Échanges réussis (meetings terminés)
            'successful_exchanges' => Meeting::where(function($query) use ($user) {
                $query->where('user1_id', $user->id)
                      ->orWhere('user2_id', $user->id);
            })
            ->where('status', 'completed')
            ->count(),

            // Annulations de RDV
            'cancelled_meetings' => Meeting::where(function($query) use ($user) {
                $query->where('user1_id', $user->id)
                      ->orWhere('user2_id', $user->id);
            })
            ->where('status', 'cancelled')
            ->count(),

            // Messages envoyés
            'messages_sent' => Message::where('sender_id', $user->id)->count(),

            // Messages reçus
            'messages_received' => Message::where('receiver_id', $user->id)->count(),

            // Avis donnés (à implémenter si vous avez un système d'avis)
            'reviews_given' => 0, // TODO: Implémenter quand le système d'avis existe

            // Avis reçus (à implémenter si vous avez un système d'avis)
            'reviews_received' => 0, // TODO: Implémenter quand le système d'avis existe

            // Âge du compte en jours
            'account_age_days' => Carbon::parse($user->created_at)->diffInDays(now()),
        ];
    }

    /**
     * Détecter les comportements suspects avec l'IA
     * 
     * @param User $user
     * @param UserTrustScore $trustScore
     * @return void
     */
    protected function detectSuspiciousBehavior(User $user, UserTrustScore $trustScore)
    {
        $suspiciousReasons = [];

        // 1. Trop d'annulations de RDV
        if ($trustScore->cancelled_meetings > 5) {
            $suspiciousReasons[] = "Trop d'annulations de rendez-vous ({$trustScore->cancelled_meetings})";
        }

        // 2. Ratio annulations / échanges réussis trop élevé
        if ($trustScore->successful_exchanges > 0) {
            $ratio = $trustScore->cancelled_meetings / $trustScore->successful_exchanges;
            if ($ratio > 2) {
                $suspiciousReasons[] = "Ratio annulations/échanges anormal (x{$ratio})";
            }
        }

        // 3. Compte très nouveau avec beaucoup d'activité suspecte
        if ($trustScore->account_age_days < 7 && $trustScore->cancelled_meetings > 2) {
            $suspiciousReasons[] = "Compte récent avec comportement suspect";
        }

        // 4. Aucune activité de messagerie (compte dormant ou bot)
        $totalMessages = $trustScore->messages_sent + $trustScore->messages_received;
        if ($totalMessages === 0 && $trustScore->account_age_days > 30) {
            $suspiciousReasons[] = "Aucune activité de messagerie détectée";
        }

        // 5. Activité anormale : trop de messages en peu de temps (spam potentiel)
        $recentMessages = Message::where('sender_id', $user->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();
        
        if ($recentMessages > 50) {
            $suspiciousReasons[] = "Activité de spam détectée ({$recentMessages} messages/heure)";
        }

        // Si des raisons suspectes sont détectées
        if (!empty($suspiciousReasons)) {
            $trustScore->reportSuspiciousActivity(implode(', ', $suspiciousReasons));
        }
    }

    /**
     * Calculer les scores de tous les utilisateurs (batch)
     * Utile pour mettre à jour tous les scores d'un coup
     * 
     * @return int Nombre d'utilisateurs traités
     */
    public function calculateAllUserScores()
    {
        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            $this->calculateUserTrustScore($user);
            $count++;
        }

        return $count;
    }

    /**
     * Obtenir les utilisateurs suspects pour l'admin
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSuspiciousUsers()
    {
        return UserTrustScore::with('user')
            ->suspicious()
            ->orderBy('trust_score', 'asc')
            ->get();
    }

    /**
     * Obtenir les utilisateurs vérifiés
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVerifiedUsers()
    {
        return UserTrustScore::with('user')
            ->verified()
            ->orderBy('trust_score', 'desc')
            ->get();
    }

    /**
     * Obtenir les statistiques globales de confiance
     * 
     * @return array
     */
    public function getGlobalStats()
    {
        return [
            'total_users' => User::count(),
            'verified_users' => UserTrustScore::verified()->count(),
            'suspicious_users' => UserTrustScore::suspicious()->count(),
            'average_score' => round(UserTrustScore::avg('trust_score'), 2),
            'excellent_users' => UserTrustScore::where('trust_score', '>=', 90)->count(),
            'good_users' => UserTrustScore::whereBetween('trust_score', [60, 89])->count(),
            'low_users' => UserTrustScore::where('trust_score', '<', 60)->count(),
        ];
    }

    /**
     * Réinitialiser le score d'un utilisateur (admin)
     * 
     * @param User $user
     * @return UserTrustScore
     */
    public function resetUserScore(User $user)
    {
        $trustScore = $user->trustScore;
        
        if ($trustScore) {
            $trustScore->trust_score = 50;
            $trustScore->is_verified = false;
            $trustScore->verification_date = null;
            $trustScore->last_suspicious_activity = null;
            $trustScore->last_suspicious_at = null;
            $trustScore->score_history = [];
            $trustScore->save();
        }

        return $this->calculateUserTrustScore($user);
    }

    /**
     * Déclencher le recalcul après une action utilisateur
     * 
     * @param User $user
     * @param string $action (meeting_completed, meeting_cancelled, message_sent, etc.)
     * @return void
     */
    public function triggerRecalculation(User $user, string $action)
    {
        // Recalculer seulement si l'action est significative
        $significantActions = [
            'meeting_completed',
            'meeting_cancelled',
            'message_sent',
            'review_given',
            'review_received',
        ];

        if (in_array($action, $significantActions)) {
            $this->calculateUserTrustScore($user);
        }
    }
}
