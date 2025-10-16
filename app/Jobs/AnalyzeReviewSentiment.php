<?php

namespace App\Jobs;

use App\Models\Review;
use App\Services\AI\SentimentAnalyzer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeReviewSentiment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Review $review;
    public int $tries = 3; // Nombre de tentatives en cas d'échec
    public int $timeout = 60; // Timeout en secondes

    /**
     * Create a new job instance.
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Execute the job.
     */
    public function handle(SentimentAnalyzer $analyzer): void
    {
        try {
            Log::info('Starting sentiment analysis for review', ['review_id' => $this->review->id]);

            // Analyser le sentiment
            $analysis = $analyzer->analyze($this->review);

            if (!$analysis) {
                Log::warning('Sentiment analysis failed', ['review_id' => $this->review->id]);
                return;
            }

            // Mettre à jour la review avec les résultats
            $this->review->update([
                'sentiment_score' => $analysis['sentiment_score'],
                'sentiment_label' => $analysis['sentiment_label'],
                'toxicity_score' => $analysis['toxicity_score'],
                'ai_summary' => $analysis['ai_summary'],
                'ai_topics' => json_encode($analysis['ai_topics']),
                'requires_manual_review' => $analysis['requires_manual_review'],
                'analyzed_at' => now(),
            ]);

            Log::info('Sentiment analysis completed successfully', [
                'review_id' => $this->review->id,
                'sentiment' => $analysis['sentiment_label'],
                'score' => $analysis['sentiment_score'],
            ]);

            // Vérifier si le livre a maintenant 3+ avis analysés pour générer automatiquement le BookInsight
            $this->checkAndGenerateBookInsight();

        } catch (\Exception $e) {
            Log::error('Error analyzing review sentiment', [
                'review_id' => $this->review->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Relancer le job si on n'a pas atteint le max de tentatives
            if ($this->attempts() < $this->tries) {
                $this->release(60); // Réessayer dans 60 secondes
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Sentiment analysis job failed permanently', [
            'review_id' => $this->review->id,
            'error' => $exception->getMessage(),
        ]);
    }

    /**
     * Check if book has 3+ analyzed reviews and generate BookInsight automatically
     */
    protected function checkAndGenerateBookInsight(): void
    {
        try {
            $book = $this->review->book;
            
            // Compter les avis analysés pour ce livre
            $analyzedReviewsCount = $book->reviews()
                ->whereNotNull('analyzed_at')
                ->count();

            Log::info('Checking BookInsight generation requirement', [
                'book_id' => $book->id,
                'analyzed_reviews_count' => $analyzedReviewsCount,
            ]);

            // Générer ou mettre à jour le BookInsight si on a 3+ avis analysés
            if ($analyzedReviewsCount >= 3) {
                // Dispatch le job de génération de BookInsight
                \App\Jobs\GenerateBookInsightJob::dispatch($book);
                
                Log::info('BookInsight generation job dispatched', [
                    'book_id' => $book->id,
                    'analyzed_reviews_count' => $analyzedReviewsCount,
                ]);
            } else {
                Log::info('Not enough analyzed reviews for BookInsight generation', [
                    'book_id' => $book->id,
                    'analyzed_reviews_count' => $analyzedReviewsCount,
                    'required' => 3,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error checking BookInsight generation', [
                'book_id' => $this->review->book_id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
