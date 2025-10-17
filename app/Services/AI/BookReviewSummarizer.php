<?php

namespace App\Services\AI;

use App\Models\Book;
use App\Models\BookInsight;
use App\Services\AI\GeminiService;
use Illuminate\Support\Facades\Log;

class BookReviewSummarizer
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Générer ou mettre à jour l'insight d'un livre
     */
    public function generateInsight(Book $book): ?BookInsight
    {
        // Vérifier qu'il y a au moins 3 avis pour générer un résumé pertinent
        $reviews = $book->reviews()->whereNotNull('analyzed_at')->get();
        
        if ($reviews->count() < 3) {
            Log::info('Not enough reviews to generate insight', ['book_id' => $book->id, 'count' => $reviews->count()]);
            return null;
        }

        Log::info('Generating book insight', ['book_id' => $book->id, 'title' => $book->title]);

        // Construire le prompt pour Gemini
        $prompt = $this->buildPrompt($book, $reviews);

        try {
            // Appeler Gemini API
            $response = $this->gemini->analyzeStructured($prompt);

            if (!$response) {
                Log::error('Failed to generate insight - no response from Gemini', ['book_id' => $book->id]);
                return null;
            }

            // Parser et structurer la réponse
            $data = $this->parseResponse($response, $reviews);

            // Créer ou mettre à jour l'insight
            $insight = $book->insight()->updateOrCreate(
                ['book_id' => $book->id],
                array_merge($data, [
                    'last_generated_at' => now(),
                    'total_reviews' => $reviews->count(),
                ])
            );

            Log::info('Book insight generated successfully', [
                'book_id' => $book->id,
                'insight_id' => $insight->id,
                'reviews_count' => $reviews->count(),
            ]);

            return $insight;

        } catch (\Exception $e) {
            Log::error('Error generating book insight', [
                'book_id' => $book->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Construire le prompt pour l'analyse
     */
    protected function buildPrompt(Book $book, $reviews): string
    {
        $reviewsText = $reviews->map(function ($review, $index) {
            return sprintf(
                "[Avis %d] Note: %d/5 | Sentiment: %s (%.2f) | Commentaire: %s",
                $index + 1,
                $review->rating,
                $review->sentiment_label ?? 'N/A',
                $review->sentiment_score ?? 0,
                $review->comment
            );
        })->join("\n\n");

        return <<<PROMPT
Tu es un expert en analyse de critiques littéraires. Analyse les avis suivants pour le livre "{$book->title}" de {$book->author}.

AVIS DES LECTEURS ({$reviews->count()} avis) :
{$reviewsText}

Ta mission : Créer un résumé structuré et objectif de ces avis.

STRUCTURE ATTENDUE (format JSON strict) :
{
    "summary": "Un paragraphe de 3-4 phrases résumant l'opinion générale des lecteurs (mentionner les aspects récurrents)",
    "positive_points": [
        "Point positif 1 avec nombre de mentions (ex: Personnages attachants - mentionné 5 fois)",
        "Point positif 2 avec nombre de mentions",
        "Point positif 3 avec nombre de mentions"
    ],
    "negative_points": [
        "Point négatif 1 avec nombre de mentions",
        "Point négatif 2 avec nombre de mentions"
    ],
    "top_themes": [
        "Thème 1 (ex: Amitié)",
        "Thème 2 (ex: Aventure)",
        "Thème 3",
        "Thème 4",
        "Thème 5"
    ]
}

CONSIGNES IMPORTANTES :
- Le résumé doit être neutre et factuel
- Compter précisément combien de fois chaque aspect est mentionné
- Extraire 3-5 points positifs max (les plus mentionnés)
- Extraire 0-3 points négatifs (seulement si significatifs)
- Identifier 5 thèmes principaux max
- Répondre UNIQUEMENT en JSON valide, sans texte avant/après
PROMPT;
    }

    /**
     * Parser et structurer la réponse de Gemini
     */
    protected function parseResponse(?array $response, $reviews): array
    {
        if (!$response) {
            Log::warning('No response from Gemini to parse');
            return $this->generateFallbackData($reviews);
        }

        // La réponse est déjà un array structuré depuis analyzeStructured()
        $data = $response;

        // Calculer les statistiques
        $sentimentCounts = [
            'positive' => $reviews->where('sentiment_label', 'positive')->count(),
            'neutral' => $reviews->where('sentiment_label', 'neutral')->count(),
            'negative' => $reviews->where('sentiment_label', 'negative')->count(),
        ];

        $total = $reviews->count();
        $sentimentDistribution = [
            'positive' => $total > 0 ? round(($sentimentCounts['positive'] / $total) * 100) : 0,
            'neutral' => $total > 0 ? round(($sentimentCounts['neutral'] / $total) * 100) : 0,
            'negative' => $total > 0 ? round(($sentimentCounts['negative'] / $total) * 100) : 0,
        ];

        return [
            'reviews_summary' => $data['summary'] ?? 'Résumé non disponible',
            'positive_points' => $data['positive_points'] ?? [],
            'negative_points' => $data['negative_points'] ?? [],
            'top_themes' => $data['top_themes'] ?? [],
            'sentiment_distribution' => $sentimentDistribution,
            'average_rating' => round($reviews->avg('rating'), 2),
            'average_sentiment' => round($reviews->avg('sentiment_score'), 2),
        ];
    }

    /**
     * Générer des données de secours en cas d'échec du parsing
     */
    protected function generateFallbackData($reviews): array
    {
        $sentimentCounts = [
            'positive' => $reviews->where('sentiment_label', 'positive')->count(),
            'neutral' => $reviews->where('sentiment_label', 'neutral')->count(),
            'negative' => $reviews->where('sentiment_label', 'negative')->count(),
        ];

        $total = $reviews->count();

        return [
            'reviews_summary' => "Basé sur {$total} avis, ce livre reçoit une note moyenne de " . round($reviews->avg('rating'), 1) . "/5.",
            'positive_points' => ['Analyse automatique non disponible'],
            'negative_points' => [],
            'top_themes' => [],
            'sentiment_distribution' => [
                'positive' => $total > 0 ? round(($sentimentCounts['positive'] / $total) * 100) : 0,
                'neutral' => $total > 0 ? round(($sentimentCounts['neutral'] / $total) * 100) : 0,
                'negative' => $total > 0 ? round(($sentimentCounts['negative'] / $total) * 100) : 0,
            ],
            'average_rating' => round($reviews->avg('rating'), 2),
            'average_sentiment' => round($reviews->avg('sentiment_score'), 2),
        ];
    }

    /**
     * Générer les insights pour plusieurs livres
     */
    public function generateBulkInsights(int $limit = 10): array
    {
        $books = Book::has('reviews', '>=', 3)
            ->doesntHave('insight')
            ->limit($limit)
            ->get();

        $results = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
        ];

        foreach ($books as $book) {
            $insight = $this->generateInsight($book);

            if ($insight) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }
}
