<?php

namespace App\Services;

use App\Models\User;
use App\Services\TrustScoreService;
use Illuminate\Support\Facades\Log;

/**
 * Service pour la mise à jour automatique des scores de confiance
 * Déclenché après les actions importantes des utilisateurs
 */
class TrustScoreAutoUpdateService
{
    protected $trustScoreService;

    public function __construct(TrustScoreService $trustScoreService)
    {
        $this->trustScoreService = $trustScoreService;
    }

    /**
     * Mettre à jour le score après l'envoi d'un message
     * 
     * @param User $sender
     * @return void
     */
    public function handleMessageSent(User $sender)
    {
        try {
            $this->trustScoreService->triggerRecalculation($sender, 'message_sent');
            
            Log::info("Trust Score Auto-Update: Message sent by user #{$sender->id}");
        } catch (\Exception $e) {
            Log::error("Trust Score Auto-Update Error (Message): " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le score après confirmation d'un meeting
     * Met à jour les scores des DEUX participants
     * 
     * @param User $user1
     * @param User $user2
     * @return void
     */
    public function handleMeetingConfirmed(User $user1, User $user2)
    {
        try {
            $this->trustScoreService->calculateUserTrustScore($user1);
            $this->trustScoreService->calculateUserTrustScore($user2);
            
            Log::info("Trust Score Auto-Update: Meeting confirmed between users #{$user1->id} and #{$user2->id}");
        } catch (\Exception $e) {
            Log::error("Trust Score Auto-Update Error (Meeting Confirmed): " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le score après complétion d'un meeting (échange réussi)
     * Met à jour les scores des DEUX participants avec bonus
     * 
     * @param User $user1
     * @param User $user2
     * @return void
     */
    public function handleMeetingCompleted(User $user1, User $user2)
    {
        try {
            // Recalculer les scores (les échanges réussis sont comptés automatiquement)
            $this->trustScoreService->calculateUserTrustScore($user1);
            $this->trustScoreService->calculateUserTrustScore($user2);
            
            Log::info("Trust Score Auto-Update: Meeting completed between users #{$user1->id} and #{$user2->id}");
        } catch (\Exception $e) {
            Log::error("Trust Score Auto-Update Error (Meeting Completed): " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le score après annulation d'un meeting
     * Met à jour les scores des DEUX participants (pénalité)
     * 
     * @param User $user1
     * @param User $user2
     * @return void
     */
    public function handleMeetingCancelled(User $user1, User $user2)
    {
        try {
            // Recalculer les scores (les annulations sont comptées automatiquement)
            $this->trustScoreService->calculateUserTrustScore($user1);
            $this->trustScoreService->calculateUserTrustScore($user2);
            
            Log::info("Trust Score Auto-Update: Meeting cancelled between users #{$user1->id} and #{$user2->id}");
        } catch (\Exception $e) {
            Log::error("Trust Score Auto-Update Error (Meeting Cancelled): " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le score d'un seul utilisateur
     * Utilisé pour les actions individuelles
     * 
     * @param User $user
     * @param string $reason
     * @return void
     */
    public function updateSingleUser(User $user, string $reason = 'manual_update')
    {
        try {
            $this->trustScoreService->calculateUserTrustScore($user);
            
            Log::info("Trust Score Auto-Update: Single user update #{$user->id}, reason: {$reason}");
        } catch (\Exception $e) {
            Log::error("Trust Score Auto-Update Error (Single User): " . $e->getMessage());
        }
    }

    /**
     * Signaler une activité suspecte détectée manuellement
     * 
     * @param User $user
     * @param string $reason
     * @return void
     */
    public function reportSuspiciousActivity(User $user, string $reason)
    {
        try {
            $trustScore = $user->getOrCreateTrustScore();
            $trustScore->reportSuspiciousActivity($reason);
            
            Log::warning("Trust Score: Suspicious activity reported for user #{$user->id}: {$reason}");
        } catch (\Exception $e) {
            Log::error("Trust Score Error (Report Suspicious): " . $e->getMessage());
        }
    }

    /**
     * Vérifier et mettre à jour le score si nécessaire
     * Utile pour les actions où on veut vérifier avant de recalculer
     * 
     * @param User $user
     * @param int $threshold (minimum de jours avant recalcul)
     * @return bool True si mis à jour, False sinon
     */
    public function updateIfNeeded(User $user, int $threshold = 1)
    {
        try {
            $trustScore = $user->trustScore;
            
            if (!$trustScore) {
                // Pas de score existant, créer
                $this->trustScoreService->calculateUserTrustScore($user);
                return true;
            }

            // Vérifier la date du dernier calcul
            if (!$trustScore->last_calculated_at || 
                $trustScore->last_calculated_at->diffInDays(now()) >= $threshold) {
                
                $this->trustScoreService->calculateUserTrustScore($user);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Trust Score Error (Update If Needed): " . $e->getMessage());
            return false;
        }
    }
}
