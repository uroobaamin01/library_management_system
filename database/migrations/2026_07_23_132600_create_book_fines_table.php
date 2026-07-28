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
        if (!Schema::hasTable('book_fines')) {
            Schema::create('book_fines', function (Blueprint $table) {
                $table->id();
                $table->foreignId('borrow_transaction_id')->constrained('borrow_transactions')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
                $table->decimal('amount', 8, 2);
                $table->integer('overdue_days')->default(0);
                $table->enum('status', ['pending', 'paid', 'waived'])->default('pending');
                $table->timestamp('paid_at')->nullable();
                $table->string('payment_method')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_fines');
    }
};