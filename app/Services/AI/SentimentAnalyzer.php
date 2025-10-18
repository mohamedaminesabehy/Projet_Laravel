<?php

namespace App\Services\AI;

use App\Models\Review;
use Illuminate\Support\Facades\Log;

class SentimentAnalyzer
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Analyser le sentiment d'un avis
     *
     * @param Review $review
     * @return array|null
     */
    public function analyze(Review $review): ?array
    {
        if (!$this->gemini->isConfigured()) {
            Log::warning('Gemini API not configured. Skipping sentiment analysis.');
            return null;
        }

        $prompt = $this->buildPrompt($review);
        $response = $this->gemini->analyzeStructured($prompt);

        if (!$response) {
            Log::error('Failed to analyze review sentiment', ['review_id' => $review->id]);
            return null;
        }

        return $this->normalizeResponse($response);
    }

    /**
     * Construire le prompt pour l'analyse de sentiment
     *
     * @param Review $review
     * @return string
     */
    protected function buildPrompt(Review $review): string
    {
        $bookTitle = $review->book->title ?? 'Inconnu';
        $rating = $review->rating;
        $comment = $review->comment;

        return <<<PROMPT
Tu es un expert en analyse de sentiment pour les avis de livres. 
Analyse l'avis suivant et retourne UNIQUEMENT un objet JSON (sans markdown) avec la structure exacte suivante:

{
  "sentiment_score": <nombre entre -1.0 et 1.0>,
  "sentiment_label": "<positive|neutral|negative>",
  "toxicity_score": <nombre entre 0.0 et 1.0>,
  "requires_manual_review": <true|false>,
  "ai_summary": "<résumé en 1-2 phrases>",
  "ai_topics": ["theme1", "theme2", "theme3"],
  "confidence": <nombre entre 0.0 et 1.0>
}

**Critères d'analyse:**

1. **sentiment_score**: 
   - -1.0 = très négatif
   - 0.0 = neutre
   - +1.0 = très positif
   - Tiens compte de la note (rating) ET du commentaire

2. **sentiment_label**:
   - "positive" si sentiment_score > 0.3
   - "negative" si sentiment_score < -0.3
   - "neutral" sinon

3. **toxicity_score**:
   - 0.0 = pas toxique
   - 1.0 = très toxique
   - Détecte: insultes, langage inapproprié, haine, spam

4. **requires_manual_review**:
   - true si toxicity_score > 0.5 OU incohérence entre note et commentaire
   - false sinon

5. **ai_summary**: Résumé concis de l'opinion principale

6. **ai_topics**: 3-5 thèmes principaux mentionnés (ex: "intrigue", "personnages", "style d'écriture")

7. **confidence**: Niveau de confiance de l'analyse (0.0 à 1.0)

**Avis à analyser:**

Livre: "{$bookTitle}"
Note: {$rating}/5 ⭐
Commentaire: "{$comment}"

Retourne UNIQUEMENT le JSON, sans explication supplémentaire.
PROMPT;
    }

    /**
     * Normaliser la réponse de l'API
     *
     * @param array $response
     * @return array
     */
    protected function normalizeResponse(array $response): array
    {
        return [
            'sentiment_score' => $this->clamp($response['sentiment_score'] ?? 0, -1.0, 1.0),
            'sentiment_label' => $this->normalizeSentimentLabel($response['sentiment_label'] ?? 'neutral'),
            'toxicity_score' => $this->clamp($response['toxicity_score'] ?? 0, 0.0, 1.0),
            'requires_manual_review' => (bool) ($response['requires_manual_review'] ?? false),
            'ai_summary' => $response['ai_summary'] ?? null,
            'ai_topics' => $response['ai_topics'] ?? [],
            'confidence' => $this->clamp($response['confidence'] ?? 0.5, 0.0, 1.0),
        ];
    }

    /**
     * Normaliser le label de sentiment
     *
     * @param string $label
     * @return string
     */
    protected function normalizeSentimentLabel(string $label): string
    {
        $label = strtolower(trim($label));
        
        if (in_array($label, ['positive', 'neutral', 'negative'])) {
            return $label;
        }

        // Fallback
        return 'neutral';
    }

    /**
     * Limiter une valeur entre un min et un max
     *
     * @param float $value
     * @param float $min
     * @param float $max
     * @return float
     */
    protected function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }

    /**
     * Analyser plusieurs avis en lot
     *
     * @param \Illuminate\Support\Collection $reviews
     * @return array
     */
    public function analyzeBatch($reviews): array
    {
        $results = [
            'success' => [],
            'failed' => [],
        ];

        foreach ($reviews as $review) {
            $analysis = $this->analyze($review);
            
            if ($analysis) {
                $results['success'][] = [
                    'review_id' => $review->id,
                    'analysis' => $analysis,
                ];
            } else {
                $results['failed'][] = $review->id;
            }
        }

        return $results;
    }

    /**
     * Obtenir des statistiques sur les sentiments
     *
     * @param array $reviews Collection de reviews avec analyse
     * @return array
     */
    public function getStatistics($reviews): array
    {
        $total = $reviews->count();
        
        if ($total === 0) {
            return [
                'total' => 0,
                'positive' => 0,
                'neutral' => 0,
                'negative' => 0,
                'average_sentiment' => 0,
                'average_toxicity' => 0,
                'flagged_count' => 0,
            ];
        }

        return [
            'total' => $total,
            'positive' => $reviews->where('sentiment_label', 'positive')->count(),
            'neutral' => $reviews->where('sentiment_label', 'neutral')->count(),
            'negative' => $reviews->where('sentiment_label', 'negative')->count(),
            'average_sentiment' => round($reviews->avg('sentiment_score'), 2),
            'average_toxicity' => round($reviews->avg('toxicity_score'), 2),
            'flagged_count' => $reviews->where('requires_manual_review', true)->count(),
        ];
    }
}
