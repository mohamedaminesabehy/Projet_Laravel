<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
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
        ];
    }

    public function books()
    {
        return $this->hasMany(Book::class);
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
