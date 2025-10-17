<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reviews_summary',
        'positive_points',
        'negative_points',
        'top_themes',
        'sentiment_distribution',
        'total_reviews',
        'average_rating',
        'average_sentiment',
        'last_generated_at',
    ];

    protected $casts = [
        'positive_points' => 'array',
        'negative_points' => 'array',
        'top_themes' => 'array',
        'sentiment_distribution' => 'array',
        'average_rating' => 'decimal:2',
        'average_sentiment' => 'decimal:2',
        'last_generated_at' => 'datetime',
    ];

    /**
     * Relation : Un insight appartient à un livre
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Vérifier si l'insight est récent (moins de 7 jours)
     */
    public function isRecent(): bool
    {
        if (!$this->last_generated_at) {
            return false;
        }

        return $this->last_generated_at->gt(now()->subDays(7));
    }

    /**
     * Vérifier si l'insight doit être régénéré
     */
    public function needsRegeneration(): bool
    {
        // Régénérer si :
        // 1. Jamais généré
        // 2. Ancien (plus de 30 jours)
        // 3. Nouveaux avis depuis la dernière génération
        
        if (!$this->last_generated_at) {
            return true;
        }

        if ($this->last_generated_at->lt(now()->subDays(30))) {
            return true;
        }

        $currentReviewsCount = $this->book->reviews()->count();
        if ($currentReviewsCount > $this->total_reviews) {
            return true;
        }

        return false;
    }

    /**
     * Obtenir le sentiment dominant
     */
    public function getDominantSentiment(): array
    {
        if (!$this->sentiment_distribution || !is_array($this->sentiment_distribution)) {
            return [
                'sentiment' => 'neutral',
                'percentage' => 0
            ];
        }

        $max = max($this->sentiment_distribution);
        $sentiment = array_search($max, $this->sentiment_distribution);
        
        return [
            'sentiment' => $sentiment ?: 'neutral',
            'percentage' => $max
        ];
    }

    /**
     * Obtenir le badge de sentiment
     */
    public function getSentimentBadgeAttribute(): string
    {
        $dominantData = $this->getDominantSentiment();
        $dominant = $dominantData['sentiment'];
        $percentage = $dominantData['percentage'];

        return match($dominant) {
            'positive' => '<span class="badge bg-success"><i class="fas fa-smile"></i> Positif (' . $percentage . '%)</span>',
            'negative' => '<span class="badge bg-danger"><i class="fas fa-frown"></i> Négatif (' . $percentage . '%)</span>',
            'neutral' => '<span class="badge bg-secondary"><i class="fas fa-meh"></i> Neutre (' . $percentage . '%)</span>',
            default => '<span class="badge bg-light text-dark">N/A</span>',
        };
    }
}
