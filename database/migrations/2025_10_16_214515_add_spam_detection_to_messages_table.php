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
        Schema::table('messages', function (Blueprint $table) {
            $table->decimal('spam_score', 5, 2)->default(0);
            $table->json('spam_reasons')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['spam_score', 'spam_reasons', 'is_blocked', 'blocked_at']);
        });
    }
};
