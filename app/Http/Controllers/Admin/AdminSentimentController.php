<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\AI\SentimentAnalyzer;
use App\Jobs\AnalyzeReviewSentiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSentimentController extends Controller
{
    /**
     * Display sentiment analysis dashboard
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book'])->whereNotNull('analyzed_at');

        // Filtres
        if ($request->filled('sentiment')) {
            $query->where('sentiment_label', $request->sentiment);
        }

        if ($request->filled('flagged')) {
            $query->where('requires_manual_review', true);
        }

        if ($request->filled('toxic')) {
            $query->where('toxicity_score', '>=', $request->get('toxic', 0.5));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhere('ai_summary', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'analyzed_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['analyzed_at', 'sentiment_score', 'toxicity_score'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $reviews = $query->paginate(20)->withQueryString();

        // Statistiques globales
        $stats = [
            'total_analyzed' => Review::whereNotNull('analyzed_at')->count(),
            'pending_analysis' => Review::whereNull('analyzed_at')->count(),
            'positive' => Review::where('sentiment_label', 'positive')->count(),
            'neutral' => Review::where('sentiment_label', 'neutral')->count(),
            'negative' => Review::where('sentiment_label', 'negative')->count(),
            'flagged' => Review::where('requires_manual_review', true)->count(),
            'high_toxicity' => Review::where('toxicity_score', '>=', 0.7)->count(),
            'avg_sentiment' => round(Review::whereNotNull('sentiment_score')->avg('sentiment_score'), 2),
            'avg_toxicity' => round(Review::whereNotNull('toxicity_score')->avg('toxicity_score'), 2),
        ];

        return view('admin.sentiment.index', compact('reviews', 'stats'));
    }

    /**
     * Show detailed analysis for a review
     */
    public function show(Review $review)
    {
        $review->load(['user', 'book', 'reactions']);

        return view('admin.sentiment.show', compact('review'));
    }

    /**
     * Reanalyze a review
     */
    public function reanalyze(Review $review)
    {
        AnalyzeReviewSentiment::dispatch($review);

        return back()->with('success', 'Analyse en cours... Rafraîchissez la page dans quelques secondes.');
    }

    /**
     * Bulk analyze unanalyzed reviews
     */
    public function bulkAnalyze(Request $request)
    {
        // Augmenter le timeout pour cette requête
        set_time_limit(300); // 5 minutes
        
        // Limiter à 10 avis maximum pour éviter le timeout
        $limit = min($request->get('limit', 10), 10);
        
        $reviews = Review::whereNull('analyzed_at')
            ->limit($limit)
            ->get();

        foreach ($reviews as $review) {
            AnalyzeReviewSentiment::dispatch($review);
        }

        return back()->with('success', "{$reviews->count()} avis analysés avec succès !");
    }

    /**
     * Get analytics data for charts
     */
    public function analytics(Request $request)
    {
        $days = $request->get('days', 30);

        // Tendance des sentiments par jour
        $sentimentTrend = Review::whereNotNull('analyzed_at')
            ->where('created_at', '>=', now()->subDays($days))
            ->select(
                DB::raw('DATE(analyzed_at) as date'),
                DB::raw('AVG(sentiment_score) as avg_sentiment'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Distribution des sentiments
        $sentimentDistribution = [
            'positive' => Review::where('sentiment_label', 'positive')->count(),
            'neutral' => Review::where('sentiment_label', 'neutral')->count(),
            'negative' => Review::where('sentiment_label', 'negative')->count(),
        ];

        // Top topics
        $topTopics = Review::whereNotNull('ai_topics')
            ->get()
            ->pluck('ai_topics')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        // Reviews les plus toxiques
        $toxicReviews = Review::whereNotNull('toxicity_score')
            ->orderBy('toxicity_score', 'desc')
            ->limit(10)
            ->with(['user', 'book'])
            ->get();

        // Reviews nécessitant une revue manuelle
        $flaggedReviews = Review::where('requires_manual_review', true)
            ->with(['user', 'book'])
            ->orderBy('analyzed_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'sentiment_trend' => $sentimentTrend,
            'sentiment_distribution' => $sentimentDistribution,
            'top_topics' => $topTopics,
            'toxic_reviews' => $toxicReviews,
            'flagged_reviews' => $flaggedReviews,
        ]);
    }

    /**
     * Export sentiment data
     */
    public function export(Request $request)
    {
        $reviews = Review::whereNotNull('analyzed_at')
            ->with(['user', 'book'])
            ->get();

        $csv = "ID,User,Book,Rating,Sentiment,Score,Toxicity,Summary,Flagged,Date\n";

        foreach ($reviews as $review) {
            $csv .= sprintf(
                "%d,%s,%s,%d,%s,%.2f,%.2f,%s,%s,%s\n",
                $review->id,
                $review->user->name ?? 'N/A',
                $review->book->title ?? 'N/A',
                $review->rating,
                $review->sentiment_label ?? 'N/A',
                $review->sentiment_score ?? 0,
                $review->toxicity_score ?? 0,
                str_replace(["\n", "\r", ','], ' ', $review->ai_summary ?? ''),
                $review->requires_manual_review ? 'Yes' : 'No',
                $review->analyzed_at->format('Y-m-d H:i:s')
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sentiment-analysis-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
