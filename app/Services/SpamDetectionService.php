<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpamDetectionService
{
    private $apiToken;
    private $apiUrl = 'https://api-inference.huggingface.co/models/mrm8488/bert-tiny-finetuned-sms-spam-detection';

    public function __construct()
    {
        $this->apiToken = env('HUGGINGFACE_API_TOKEN');
    }

    /**
     * Analyser un message avec l'IA Hugging Face
     * 
     * @param string $message Le contenu du message à analyser
     * @return array ['is_spam' => bool, 'spam_score' => float, 'reasons' => array]
     */
    public function analyzeMessage(string $message): array
    {
        try {
            // D'abord, faire l'analyse locale (plus rapide et fiable)
            $localAnalysis = $this->fallbackAnalysis($message);
            
            // Si le score local est déjà élevé (>60), pas besoin d'appeler l'API
            if ($localAnalysis['spam_score'] >= 60) {
                return $localAnalysis;
            }

            // Sinon, essayer l'API Hugging Face avec timeout court
            $response = Http::timeout(3)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
            ])->post($this->apiUrl, [
                'inputs' => $message,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $this->processApiResponse($result, $message);
            }

            // Si l'API échoue, retourner l'analyse locale
            return $localAnalysis;

        } catch (\Exception $e) {
            Log::error('Spam Detection Error: ' . $e->getMessage());
            
            // Fallback en cas d'erreur
            return $this->fallbackAnalysis($message);
        }
    }

    /**
     * Traiter la réponse de l'API Hugging Face
     */
    private function processApiResponse($result, string $message): array
    {
        // Format de réponse Hugging Face : [[{"label": "SPAM", "score": 0.95}, {"label": "HAM", "score": 0.05}]]
        if (isset($result[0]) && is_array($result[0])) {
            $predictions = $result[0];
            
            $spamScore = 0;
            foreach ($predictions as $prediction) {
                if (strtoupper($prediction['label']) === 'SPAM') {
                    $spamScore = $prediction['score'] * 100;
                    break;
                }
            }

            $reasons = $this->detectReasons($message);
            $isSpam = $spamScore >= 70; // Seuil de 70%

            return [
                'is_spam' => $isSpam,
                'spam_score' => round($spamScore, 2),
                'reasons' => $reasons,
            ];
        }

        return $this->fallbackAnalysis($message);
    }

    /**
     * Détecter les raisons spécifiques du spam
     */
    private function detectReasons(string $message): array
    {
        $reasons = [];
        $messageLower = mb_strtolower($message);

        // 1. Mots suspects
        $spamKeywords = [
            'urgent', 'gratuit', 'promo', 'offre', 'cliquez', 'argent', 
            'paypal', 'bitcoin', 'crypto', 'gagnez', 'euros', 'dollars',
            'maintenant', 'immédiatement', 'limité', 'exclusif'
        ];

        foreach ($spamKeywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                $reasons[] = "Mot suspect détecté : \"$keyword\"";
            }
        }

        // 2. MAJUSCULES excessives
        $upperCount = preg_match_all('/[A-Z]/', $message);
        $totalLetters = preg_match_all('/[a-zA-Z]/', $message);
        
        if ($totalLetters > 0 && ($upperCount / $totalLetters) > 0.3) {
            $percentage = round(($upperCount / $totalLetters) * 100);
            $reasons[] = "MAJUSCULES excessives ({$percentage}% du texte)";
        }

        // 3. Liens suspects
        if (preg_match_all('/https?:\/\/[^\s]+/', $message, $matches)) {
            $linkCount = count($matches[0]);
            $reasons[] = "Lien(s) externe(s) détecté(s) ({$linkCount})";
            
            foreach ($matches[0] as $url) {
                if (!strpos($url, 'bookshare') && !strpos($url, 'localhost')) {
                    $reasons[] = "URL externe : " . substr($url, 0, 50);
                }
            }
        }

        return $reasons;
    }

    /**
     * Analyse locale de secours (fallback) si API échoue
     */
    private function fallbackAnalysis(string $message): array
    {
        $score = 0;
        $reasons = $this->detectReasons($message);

        // Calcul basé sur les raisons détectées
        foreach ($reasons as $reason) {
            // Mots suspects : +30 points par mot
            if (strpos($reason, 'Mot suspect détecté') !== false) {
                $score += 30;
            }
            // MAJUSCULES : +25 points
            if (strpos($reason, 'MAJUSCULES') !== false) {
                $score += 25;
            }
            // Liens : +35 points par lien
            if (strpos($reason, 'Lien') !== false || strpos($reason, 'URL') !== false) {
                $score += 35;
            }
        }

        $score = min($score, 100); // Max 100

        return [
            'is_spam' => $score >= 70,
            'spam_score' => round($score, 2),
            'reasons' => $reasons,
            'method' => 'local', // Indique que c'est une analyse locale
        ];
    }

    /**
     * Obtenir les statistiques globales de spam
     */
    public function getSpamStats(): array
    {
        $totalMessages = \App\Models\Message::count();
        $blockedMessages = \App\Models\Message::where('is_blocked', true)->count();
        $todayBlocked = \App\Models\Message::where('is_blocked', true)
            ->whereDate('blocked_at', today())
            ->count();

        return [
            'total' => $totalMessages,
            'blocked' => $blockedMessages,
            'today_blocked' => $todayBlocked,
            'block_rate' => $totalMessages > 0 ? round(($blockedMessages / $totalMessages) * 100, 1) : 0,
        ];
    }
}
