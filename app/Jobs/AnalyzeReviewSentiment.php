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
}
