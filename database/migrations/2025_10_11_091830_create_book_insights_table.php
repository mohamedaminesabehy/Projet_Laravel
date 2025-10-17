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
        Schema::create('book_insights', function (Blueprint $table) {
            $table->id();
            
            // Relation avec books (one-to-one)
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->unique('book_id'); // Un seul insight par livre
            
            // Résumé AI des avis
            $table->text('reviews_summary')->nullable();
            
            // Points positifs (JSON array)
            $table->json('positive_points')->nullable();
            
            // Points négatifs (JSON array)
            $table->json('negative_points')->nullable();
            
            // Thèmes principaux (JSON array)
            $table->json('top_themes')->nullable();
            
            // Distribution des sentiments (JSON object)
            $table->json('sentiment_distribution')->nullable();
            
            // Statistiques
            $table->integer('total_reviews')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->decimal('average_sentiment', 3, 2)->nullable();
            
            // Métadonnées
            $table->timestamp('last_generated_at')->nullable();
            
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index('last_generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_insights');
    }
};
