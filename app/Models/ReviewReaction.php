<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewReaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review_reactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'review_id',
        'user_id',
        'reaction_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Reaction type constants
     */
    const TYPE_LIKE = 'like';
    const TYPE_DISLIKE = 'dislike';

    /**
     * Get available reaction types
     *
     * @return array
     */
    public static function getReactionTypes(): array
    {
        return [
            self::TYPE_LIKE,
            self::TYPE_DISLIKE,
        ];
    }

    /**
     * Get the review that owns the reaction.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the user that owns the reaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if reaction is a like
     *
     * @return bool
     */
    public function isLike(): bool
    {
        return $this->reaction_type === self::TYPE_LIKE;
    }

    /**
     * Check if reaction is a dislike
     *
     * @return bool
     */
    public function isDislike(): bool
    {
        return $this->reaction_type === self::TYPE_DISLIKE;
    }

    /**
     * Toggle reaction type
     *
     * @return void
     */
    public function toggle(): void
    {
        $this->reaction_type = $this->isLike() ? self::TYPE_DISLIKE : self::TYPE_LIKE;
        $this->save();
    }

    /**
     * Scope to get only likes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLikes($query)
    {
        return $query->where('reaction_type', self::TYPE_LIKE);
    }

    /**
     * Scope to get only dislikes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDislikes($query)
    {
        return $query->where('reaction_type', self::TYPE_DISLIKE);
    }

    /**
     * Scope to get reactions for a specific review
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $reviewId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForReview($query, $reviewId)
    {
        return $query->where('review_id', $reviewId);
    }

    /**
     * Scope to get reactions by a specific user
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
