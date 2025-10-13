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
        if (!Schema::hasColumn('messages', 'sender_id')) {
            $table->unsignedBigInteger('sender_id');
        }
        if (!Schema::hasColumn('messages', 'receiver_id')) {
            $table->unsignedBigInteger('receiver_id');
        }
        if (!Schema::hasColumn('messages', 'date_envoi')) {
            $table->timestamp('date_envoi')->nullable();
        }

        // Ajoutez les relations si nécessaire
        $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropForeign(['sender_id']);
        $table->dropForeign(['receiver_id']);
        $table->dropColumn(['sender_id', 'receiver_id', 'date_envoi']);
    });
}
};
