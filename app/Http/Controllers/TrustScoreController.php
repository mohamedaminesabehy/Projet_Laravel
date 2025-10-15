<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTrustScore;
use App\Services\TrustScoreService;
use Illuminate\Http\Request;

class TrustScoreController extends Controller
{
    protected $trustScoreService;

    public function __construct(TrustScoreService $trustScoreService)
    {
        $this->trustScoreService = $trustScoreService;
    }

    /**
     * Tableau de bord principal des scores de confiance
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistiques globales
        $stats = $this->trustScoreService->getGlobalStats();

        // Top 10 utilisateurs avec les meilleurs scores
        $topUsers = UserTrustScore::with('user')
            ->orderBy('trust_score', 'desc')
            ->take(10)
            ->get();

        // Top 10 utilisateurs suspects
        $suspiciousUsers = $this->trustScoreService->getSuspiciousUsers()
            ->take(10);

        // Utilisateurs récemment vérifiés
        $recentlyVerified = UserTrustScore::with('user')
            ->verified()
            ->orderBy('verification_date', 'desc')
            ->take(5)
            ->get();

        return view('admin.trust-scores.trust-score-dashboard', compact(
            'stats',
            'topUsers',
            'suspiciousUsers',
            'recentlyVerified'
        ));
    }

    /**
     * Liste complète des utilisateurs avec leurs scores
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function users(Request $request)
    {
        $query = UserTrustScore::with('user');

        // Filtres
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'verified':
                    $query->verified();
                    break;
                case 'suspicious':
                    $query->suspicious();
                    break;
                case 'excellent':
                    $query->where('trust_score', '>=', 90);
                    break;
                case 'good':
                    $query->whereBetween('trust_score', [60, 89]);
                    break;
                case 'low':
                    $query->where('trust_score', '<', 60);
                    break;
            }
        }

        // Recherche par nom
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Tri
        $sortBy = $request->get('sort', 'trust_score');
        $sortDir = $request->get('dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $users = $query->paginate(20);

        return view('admin.trust-scores.trust-score-users-list', compact('users'));
    }

    /**
     * Détails d'un utilisateur spécifique
     * 
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Récupérer ou créer le score
        $trustScore = $user->getOrCreateTrustScore();

        // Historique des scores (graphique)
        $scoreHistory = $trustScore->score_history ?? [];

        return view('admin.trust-scores.trust-score-user-details', compact('user', 'trustScore', 'scoreHistory'));
    }

    /**
     * Recalculer le score d'un utilisateur
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recalculate(User $user)
    {
        $trustScore = $this->trustScoreService->calculateUserTrustScore($user);

        return back()->with('success', "Score de {$user->first_name} {$user->last_name} recalculé avec succès ! Nouveau score : {$trustScore->trust_score}");
    }

    /**
     * Réinitialiser le score d'un utilisateur
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(User $user)
    {
        $this->trustScoreService->resetUserScore($user);

        return back()->with('success', "Score de {$user->first_name} {$user->last_name} réinitialisé à 50.");
    }

    /**
     * Recalculer les scores de TOUS les utilisateurs
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recalculateAll()
    {
        $count = $this->trustScoreService->calculateAllUserScores();

        return back()->with('success', "Scores de {$count} utilisateurs recalculés avec succès !");
    }

    /**
     * Marquer une activité suspecte comme résolue
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resolveSuspicious(User $user)
    {
        $trustScore = $user->trustScore;

        if ($trustScore) {
            $trustScore->last_suspicious_activity = null;
            $trustScore->last_suspicious_at = null;
            $trustScore->save();

            // Recalculer le score
            $this->trustScoreService->calculateUserTrustScore($user);
        }

        return back()->with('success', "Activité suspecte de {$user->first_name} {$user->last_name} marquée comme résolue.");
    }

    /**
     * API JSON pour obtenir les statistiques (pour les graphiques)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function statsJson()
    {
        $stats = $this->trustScoreService->getGlobalStats();

        // Distribution des scores par tranche
        $distribution = [
            'Excellent (90-100)' => UserTrustScore::whereBetween('trust_score', [90, 100])->count(),
            'Très bon (80-89)' => UserTrustScore::whereBetween('trust_score', [80, 89])->count(),
            'Bon (60-79)' => UserTrustScore::whereBetween('trust_score', [60, 79])->count(),
            'Moyen (40-59)' => UserTrustScore::whereBetween('trust_score', [40, 59])->count(),
            'Faible (0-39)' => UserTrustScore::whereBetween('trust_score', [0, 39])->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'distribution' => $distribution,
        ]);
    }

    /**
     * Exporter les données en CSV
     * 
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCsv()
    {
        $users = UserTrustScore::with('user')->get();

        $filename = 'trust_scores_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Score',
                'Niveau',
                'Vérifié',
                'Échanges réussis',
                'Annulations',
                'Messages envoyés',
                'Messages reçus',
                'Âge du compte (jours)',
                'Activité suspecte',
                'Dernière mise à jour'
            ]);

            // Données
            foreach ($users as $trustScore) {
                fputcsv($file, [
                    $trustScore->user->id,
                    $trustScore->user->first_name . ' ' . $trustScore->user->last_name,
                    $trustScore->user->email,
                    $trustScore->trust_score,
                    $trustScore->trust_level,
                    $trustScore->is_verified ? 'Oui' : 'Non',
                    $trustScore->successful_exchanges,
                    $trustScore->cancelled_meetings,
                    $trustScore->messages_sent,
                    $trustScore->messages_received,
                    $trustScore->account_age_days,
                    $trustScore->last_suspicious_activity ?? 'Aucune',
                    $trustScore->last_calculated_at?->format('Y-m-d H:i:s') ?? 'Jamais'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
