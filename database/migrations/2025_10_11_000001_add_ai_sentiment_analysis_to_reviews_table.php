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
        Schema::table('reviews', function (Blueprint $table) {
            // Score de sentiment (-1.0 à 1.0 : négatif à positif)
            $table->decimal('sentiment_score', 3, 2)->nullable()->after('comment');
            
            // Label du sentiment (positive, neutral, negative)
            $table->enum('sentiment_label', ['positive', 'neutral', 'negative'])->nullable()->after('sentiment_score');
            
            // Score de toxicité (0.0 à 1.0 : pas toxique à très toxique)
            $table->decimal('toxicity_score', 3, 2)->nullable()->after('sentiment_label');
            
            // Résumé généré par l'IA (optionnel)
            $table->text('ai_summary')->nullable()->after('toxicity_score');
            
            // Thèmes/topics extraits (JSON)
            $table->json('ai_topics')->nullable()->after('ai_summary');
            
            // Flag pour signaler les avis nécessitant une revue humaine
            $table->boolean('requires_manual_review')->default(false)->after('ai_topics');
            
            // Date de la dernière analyse
            $table->timestamp('analyzed_at')->nullable()->after('requires_manual_review');
            
            // Index pour améliorer les performances des requêtes
            $table->index('sentiment_label');
            $table->index('requires_manual_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['sentiment_label']);
            $table->dropIndex(['requires_manual_review']);
            
            $table->dropColumn([
                'sentiment_score',
                'sentiment_label',
                'toxicity_score',
                'ai_summary',
                'ai_topics',
                'requires_manual_review',
                'analyzed_at',
            ]);
        });
    }
};
