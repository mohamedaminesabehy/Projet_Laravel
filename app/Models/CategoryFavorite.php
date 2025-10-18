<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class CategoryFavorite extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'user_id',
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
     * Get the category that owns the favorite.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the favorite.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get favorites for a specific category
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to get favorites by a specific user
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get recent favorites (last 7 days)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Scope to get most favorited categories (with count)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMostFavorited($query, $limit = 10)
    {
        return $query->select('category_id', DB::raw('count(*) as favorites_count'))
                    ->groupBy('category_id')
                    ->orderByDesc('favorites_count')
                    ->limit($limit);
    }

    /**
     * Check if a user has favorited a specific category
     *
     * @param int $userId
     * @param int $categoryId
     * @return bool
     */
    public static function isFavorited(int $userId, int $categoryId): bool
    {
        return self::where('user_id', $userId)
                   ->where('category_id', $categoryId)
                   ->exists();
    }

    /**
     * Toggle favorite for a user and category
     * Returns true if favorited, false if unfavorited
     *
     * @param int $userId
     * @param int $categoryId
     * @return bool
     */
    public static function toggle(int $userId, int $categoryId): bool
    {
        $favorite = self::where('user_id', $userId)
                       ->where('category_id', $categoryId)
                       ->first();

        if ($favorite) {
            $favorite->delete();
            return false; // Unfavorited
        } else {
            self::create([
                'user_id' => $userId,
                'category_id' => $categoryId,
            ]);
            return true; // Favorited
        }
    }

    /**
     * Get count of favorites for a specific category
     *
     * @param int $categoryId
     * @return int
     */
    public static function countForCategory(int $categoryId): int
    {
        return self::where('category_id', $categoryId)->count();
    }

    /**
     * Get count of favorites by a specific user
     *
     * @param int $userId
     * @return int
     */
    public static function countByUser(int $userId): int
    {
        return self::where('user_id', $userId)->count();
    }
}
