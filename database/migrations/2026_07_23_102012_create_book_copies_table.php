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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('shelf_id')->nullable()->constrained()->onDelete('set null'); // <-- Added shelf_id
            
            $table->string('barcode')->unique();
            $table->integer('copy_number')->default(1);
            $table->enum('status', ['available', 'issued', 'reserved', 'lost', 'damaged'])->default('available')->index();
            $table->enum('condition', ['new', 'good', 'fair', 'damaged'])->default('good');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};