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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('isbn')->unique()->index();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('author_id')->constrained('authors')->onDelete('restrict');
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('restrict');
            $table->foreignId('language_id')->constrained('languages')->onDelete('restrict');
            $table->integer('edition')->default(1);
            $table->year('publish_year')->nullable();
            $table->integer('total_pages')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->text('summary')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['available', 'archived', 'out_of_stock'])->default('available')->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};