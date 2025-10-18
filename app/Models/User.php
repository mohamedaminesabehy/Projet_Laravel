<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants for application-level checks
    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_banned',
        'banned_at',
        'ban_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
        ];
    }

    /**
     * Get the reviews for the user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the review reactions for the user.
     */
    public function reviewReactions(): HasMany
    {
        return $this->hasMany(ReviewReaction::class);
    }

    /**
     * Get the category favorites for the user.
     */
    public function categoryFavorites(): HasMany
    {
        return $this->hasMany(CategoryFavorite::class);
    }

    /**
     * Get favorite categories (many-to-many relationship)
     */
    public function favoriteCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_favorites')
                    ->withTimestamps();
    }

    /**
     * Check if user has favorited a specific category
     */
    public function hasFavorited(int $categoryId): bool
    {
        return $this->categoryFavorites()->where('category_id', $categoryId)->exists();
    }

    /**
     * Get count of favorite categories
     */
    public function getFavoriteCategoriesCountAttribute(): int
    {
        return $this->categoryFavorites()->count();
    }

    /**
     * Get the total likes given by the user.
     */
    public function getLikesGivenCountAttribute(): int
    {
        return $this->reviewReactions()->where('reaction_type', 'like')->count();
    }

    /**
     * Get the total dislikes given by the user.
     */
    public function getDislikesGivenCountAttribute(): int
    {
        return $this->reviewReactions()->where('reaction_type', 'dislike')->count();
    }

    /**
     * Relation : Un utilisateur a un score de confiance
     */
    public function trustScore()
    {
        return $this->hasOne(UserTrustScore::class);
    }

    /**
     * Obtenir ou créer le score de confiance
     */
    public function getOrCreateTrustScore()
    {
        if (!$this->trustScore) {
            $trustScore = UserTrustScore::create([
                'user_id' => $this->id,
                'account_age_days' => now()->diffInDays($this->created_at),
            ]);
            $trustScore->calculateTrustScore();
            return $trustScore;
        }
        return $this->trustScore;
    }

    /**
     * Vérifier si l'utilisateur est vérifié
     */
    public function isVerified()
    {
        $trustScore = $this->getOrCreateTrustScore();
        return $trustScore->is_verified;
    }

    /**
     * Obtenir le score de confiance (0-100)
     */
    public function getTrustScoreValue()
    {
        $trustScore = $this->getOrCreateTrustScore();
        return $trustScore->trust_score;
    }
}
