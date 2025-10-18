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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            
            // Relation avec le message
            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            
            // Les deux utilisateurs du rendez-vous
            $table->unsignedBigInteger('user1_id');
            $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('user2_id');
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');
            
            // Les livres concernés (optionnel)
            $table->unsignedBigInteger('book1_id')->nullable();
            $table->foreign('book1_id')->references('id')->on('books')->onDelete('set null');
            
            $table->unsignedBigInteger('book2_id')->nullable();
            $table->foreign('book2_id')->references('id')->on('books')->onDelete('set null');
            
            // Informations du rendez-vous
            $table->date('meeting_date');
            $table->time('meeting_time');
            $table->string('meeting_place');
            $table->text('meeting_address')->nullable();
            
            // Statut du rendez-vous
            $table->enum('status', ['proposed', 'confirmed', 'completed', 'cancelled'])->default('proposed');
            $table->text('notes')->nullable();
            
            // Qui a proposé et quand
            $table->unsignedBigInteger('proposed_by');
            $table->foreign('proposed_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('proposed_at')->useCurrent();
            
            // Dates de confirmation, complétion, annulation
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
