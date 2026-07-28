<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookFine extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_transaction_id',
        'student_id',
        'received_by',
        'amount',
        'overdue_days',
        'status',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'overdue_days' => 'integer',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Associated Borrow Transaction
     */
    public function borrowTransaction(): BelongsTo
    {
        return $this->belongsTo(BorrowTransaction::class, 'borrow_transaction_id');
    }

    /**
     * Relationship: Student who owes fine
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relationship: Librarian who received payment
     */
    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Scope: Pending Fines
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Collected Fines
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}