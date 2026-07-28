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
        if (!Schema::hasTable('borrow_transactions')) {
            Schema::create('borrow_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('book_copy_id')->constrained('book_copies')->onDelete('cascade');
                $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
                $table->foreignId('returned_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('issued_at');
                $table->date('due_date');
                $table->timestamp('returned_at')->nullable();
                $table->integer('renewal_count')->default(0);
                $table->enum('status', ['issued', 'returned', 'overdue', 'lost'])->default('issued');
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_transactions');
    }
};