<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Add status column
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('comment');
        });

        // Migrate existing data: is_approved true -> status approved, false -> status pending
        DB::table('reviews')
            ->where('is_approved', true)
            ->update(['status' => 'approved']);
            
        DB::table('reviews')
            ->where('is_approved', false)
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
