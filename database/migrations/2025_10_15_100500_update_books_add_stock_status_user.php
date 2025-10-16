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
        // Add stock column if missing
        if (!Schema::hasColumn('books', 'stock')) {
            Schema::table('books', function (Blueprint $table) {
                $table->integer('stock')->default(0)->after('price');
            });

            // If legacy stock_quantity exists, migrate values into stock
            if (Schema::hasColumn('books', 'stock_quantity')) {
                DB::statement('UPDATE books SET stock = stock_quantity');
            }
        }

        // Add status column if missing
        if (!Schema::hasColumn('books', 'status')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('status')->default('draft')->after('cover_image');
            });
        }

        // Add user_id foreign key if missing
        if (!Schema::hasColumn('books', 'user_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('books', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('books', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};