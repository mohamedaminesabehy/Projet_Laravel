<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_favorited'];

    /**
     * Get the books for the category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Une catégorie appartient à un utilisateur (celui qui l'a créée)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the favorites for this category
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(CategoryFavorite::class);
    }

    /**
     * Get users who favorited this category (many-to-many)
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'category_favorites')
                    ->withTimestamps();
    }

    /**
     * Check if this category is favorited by a specific user
     */
    public function isFavoritedBy(?int $userId): bool
    {
        if (!$userId) {
            return false;
        }
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Get the is_favorited attribute for the currently authenticated user
     */
    public function getIsFavoritedAttribute(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->isFavoritedBy(Auth::id());
    }

    /**
     * Get the count of favorites for this category
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Scope pour rechercher par nom
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
    }

    /**
     * Scope pour filtrer les catégories par utilisateur
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Accessor pour obtenir le nombre de livres dans cette catégorie
     */
    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }

    /**
     * Mutator pour s'assurer que le nom de la catégorie est formaté correctement
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower(trim($value)));
    }
}