<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();

            $table->enum('status', ['joined','left','checked_in','cancelled'])->default('joined');
            $table->string('source')->nullable(); // "web", "qr", "admin"
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['event_id', 'user_id']); // 1 active row per user/event
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};
