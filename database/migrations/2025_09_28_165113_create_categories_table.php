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
    if (!Schema::hasTable('categories')) {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#000000');
            $table->string('icon')->default('fas fa-book');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
}
 
    /** 
     * Reverse the migrations. 
     */ 
    public function down(): void 
    { 
        Schema::dropIfExists('categories'); 
    } 
};
