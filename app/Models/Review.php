<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comment',
        'is_approved',
        'status',
        'sentiment_score',
        'sentiment_label',
        'toxicity_score',
        'ai_summary',
        'ai_topics',
        'requires_manual_review',
        'analyzed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'sentiment_score' => 'float',
        'toxicity_score' => 'float',
        'ai_topics' => 'array',
        'requires_manual_review' => 'boolean',
        'analyzed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that the review belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the reactions for the review.
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(ReviewReaction::class);
    }

    /**
     * Get the likes for the review.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ReviewReaction::class)->where('reaction_type', 'like');
    }

    /**
     * Get the dislikes for the review.
     */
    public function dislikes(): HasMany
    {
        return $this->hasMany(ReviewReaction::class)->where('reaction_type', 'dislike');
    }

    /**
     * Get likes count for the review.
     */
    public function getLikesCountAttribute(): int
    {
        return $this->reactions()->where('reaction_type', 'like')->count();
    }

    /**
     * Get dislikes count for the review.
     */
    public function getDislikesCountAttribute(): int
    {
        return $this->reactions()->where('reaction_type', 'dislike')->count();
    }

    /**
     * Get reaction score (likes - dislikes).
     */
    public function getReactionScoreAttribute(): int
    {
        return $this->likes_count - $this->dislikes_count;
    }

    /**
     * Check if user has reacted to this review.
     */
    public function hasUserReacted($userId): bool
    {
        return $this->reactions()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's reaction to this review.
     */
    public function getUserReaction($userId)
    {
        return $this->reactions()->where('user_id', $userId)->first();
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to only include pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Get the star rating as HTML.
     */
    public function getStarRatingAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    /**
     * Get formatted created at date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d/m/Y à H:i');
    }

    /**
     * Get statistics for a specific period
     */
    public static function getStatisticsByPeriod($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as total_reviews,
                AVG(rating) as average_rating,
                SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) as approved_count,
                SUM(CASE WHEN is_approved = 0 THEN 1 ELSE 0 END) as pending_count
            ')
            ->first();
    }

    /**
     * Get rating trend over time
     */
    public static function getRatingTrend($days = 30)
    {
        return self::where('created_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(created_at) as date, AVG(rating) as avg_rating, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get sentiment analysis based on ratings
     */
    public static function getSentimentAnalysis()
    {
        $reviews = self::where('is_approved', true)->get();
        
        $positive = $reviews->where('rating', '>=', 4)->count();
        $neutral = $reviews->where('rating', '=', 3)->count();
        $negative = $reviews->where('rating', '<=', 2)->count();
        $total = $reviews->count();

        return [
            'positive' => $positive,
            'neutral' => $neutral,
            'negative' => $negative,
            'positive_percentage' => $total > 0 ? ($positive / $total) * 100 : 0,
            'neutral_percentage' => $total > 0 ? ($neutral / $total) * 100 : 0,
            'negative_percentage' => $total > 0 ? ($negative / $total) * 100 : 0,
        ];
    }

    /**
     * Get average rating by category
     */
    public static function getAverageRatingByCategory()
    {
        return self::join('books', 'reviews.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->where('reviews.is_approved', true)
            ->selectRaw('categories.name, AVG(reviews.rating) as avg_rating, COUNT(reviews.id) as review_count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('avg_rating', 'desc')
            ->get();
    }

    /**
     * Get review velocity (reviews per day)
     */
    public static function getReviewVelocity($days = 30)
    {
        $totalReviews = self::where('created_at', '>=', now()->subDays($days))->count();
        return $days > 0 ? $totalReviews / $days : 0;
    }

    /**
     * Get top contributing users
     */
    public static function getTopContributors($limit = 10)
    {
        return self::with('user')
            ->selectRaw('user_id, COUNT(*) as review_count, AVG(rating) as avg_rating')
            ->groupBy('user_id')
            ->orderBy('review_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get review completion rate (approved vs total)
     */
    public static function getCompletionRate()
    {
        $total = self::count();
        $approved = self::where('is_approved', true)->count();
        
        return [
            'total' => $total,
            'approved' => $approved,
            'pending' => $total - $approved,
            'completion_rate' => $total > 0 ? ($approved / $total) * 100 : 0
        ];
    }

    /**
     * Scope to get analyzed reviews
     */
    public function scopeAnalyzed($query)
    {
        return $query->whereNotNull('analyzed_at');
    }

    /**
     * Scope to get reviews by sentiment
     */
    public function scopeBySentiment($query, string $sentiment)
    {
        return $query->where('sentiment_label', $sentiment);
    }

    /**
     * Scope to get flagged reviews
     */
    public function scopeFlagged($query)
    {
        return $query->where('requires_manual_review', true);
    }

    /**
     * Scope to get toxic reviews
     */
    public function scopeToxic($query, float $threshold = 0.5)
    {
        return $query->where('toxicity_score', '>=', $threshold);
    }

    /**
     * Get sentiment badge HTML
     */
    public function getSentimentBadgeAttribute(): string
    {
        if (!$this->sentiment_label) {
            return '<span class="badge bg-secondary">Non analysé</span>';
        }

        $badges = [
            'positive' => '<span class="badge bg-success"><i class="fas fa-smile"></i> Positif</span>',
            'neutral' => '<span class="badge bg-warning"><i class="fas fa-meh"></i> Neutre</span>',
            'negative' => '<span class="badge bg-danger"><i class="fas fa-frown"></i> Négatif</span>',
        ];

        return $badges[$this->sentiment_label] ?? '<span class="badge bg-secondary">Inconnu</span>';
    }

    /**
     * Check if review needs attention
     */
    public function needsAttention(): bool
    {
        return $this->requires_manual_review || $this->toxicity_score > 0.5;
    }

    /**
     * Get AI analysis summary
     */
    public function getAiAnalysisAttribute(): ?array
    {
        if (!$this->analyzed_at) {
            return null;
        }

        return [
            'sentiment' => [
                'score' => $this->sentiment_score,
                'label' => $this->sentiment_label,
            ],
            'toxicity' => $this->toxicity_score,
            'summary' => $this->ai_summary,
            'topics' => $this->ai_topics ?? [],
            'flagged' => $this->requires_manual_review,
            'analyzed_at' => $this->analyzed_at,
        ];
    }
}
