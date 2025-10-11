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
        Schema::create('review_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('reaction_type', ['like', 'dislike'])->default('like');
            $table->timestamps();
            
            // Un utilisateur ne peut avoir qu'une seule réaction par review
            $table->unique(['review_id', 'user_id']);
            
            // Index pour les requêtes fréquentes
            $table->index('review_id');
            $table->index('user_id');
            $table->index('reaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reactions');
    }
};
