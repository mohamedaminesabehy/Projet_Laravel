<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_trust_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Score de confiance (0-100)
            $table->integer('trust_score')->default(50);
            
            // Métriques pour le calcul du score
            $table->integer('successful_exchanges')->default(0);
            $table->integer('cancelled_meetings')->default(0);
            $table->integer('messages_sent')->default(0);
            $table->integer('messages_received')->default(0);
            $table->integer('reviews_given')->default(0);
            $table->integer('reviews_received')->default(0);
            $table->integer('account_age_days')->default(0);
            
            // Statut de vérification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verification_date')->nullable();
            
            // Activité suspecte
            $table->text('last_suspicious_activity')->nullable();
            $table->timestamp('last_suspicious_at')->nullable();
            
            // Historique des scores (JSON)
            $table->json('score_history')->nullable();
            
            // Dernière mise à jour du calcul
            $table->timestamp('last_calculated_at')->nullable();
            
            $table->timestamps();
            
            // Index pour performances
            $table->index('user_id');
            $table->index('trust_score');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_trust_scores');
    }
};
