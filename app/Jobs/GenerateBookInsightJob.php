<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\BookInsight;
use App\Services\AI\BookReviewSummarizer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateBookInsightJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Book $book;
    public int $tries = 3; // Nombre de tentatives en cas d'échec
    public int $timeout = 120; // Timeout en secondes (2 minutes pour l'analyse AI)

    /**
     * Create a new job instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(BookReviewSummarizer $summarizer): void
    {
        try {
            // Vérifier qu'on a bien 3+ avis analysés
            $analyzedReviewsCount = $this->book->reviews()
                ->whereNotNull('analyzed_at')
                ->count();

            if ($analyzedReviewsCount < 3) {
                Log::info('Not enough analyzed reviews for BookInsight generation', [
                    'book_id' => $this->book->id,
                    'analyzed_reviews_count' => $analyzedReviewsCount,
                    'required' => 3,
                ]);
                return;
            }

            Log::info('Starting BookInsight generation', [
                'book_id' => $this->book->id,
                'book_title' => $this->book->title,
                'analyzed_reviews_count' => $analyzedReviewsCount,
            ]);

            // Générer l'insight via le service AI
            $insight = $summarizer->generateInsight($this->book);

            if ($insight) {
                Log::info('BookInsight generated successfully', [
                    'book_id' => $this->book->id,
                    'insight_id' => $insight->id,
                    'total_reviews' => $insight->total_reviews,
                    'average_rating' => $insight->average_rating,
                ]);
            } else {
                Log::warning('BookInsight generation returned null', [
                    'book_id' => $this->book->id,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error generating BookInsight', [
                'book_id' => $this->book->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Relancer le job si on n'a pas atteint le max de tentatives
            if ($this->attempts() < $this->tries) {
                $this->release(120); // Réessayer dans 2 minutes
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('BookInsight generation job failed permanently', [
            'book_id' => $this->book->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
