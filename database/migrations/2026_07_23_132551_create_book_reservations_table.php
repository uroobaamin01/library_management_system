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
        if (!Schema::hasTable('book_reservations')) {
            Schema::create('book_reservations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
                $table->foreignId('book_copy_id')->nullable()->constrained('book_copies')->onDelete('set null');
                $table->timestamp('reserved_at')->useCurrent();
                $table->timestamp('expires_at')->nullable();
                $table->enum('status', ['pending', 'fulfilled', 'expired', 'cancelled'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reservations');
    }
};