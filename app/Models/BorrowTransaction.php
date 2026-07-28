<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'book_copy_id',
        'issued_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Scope a query to only include overdue borrows.
     */
    public function scopeOverdue($query)
    {
        return $query->whereNull('returned_at')
                     ->where('due_date', '<', now());
    }

    /**
     * Relationship with Student (User model)
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relationship with Book Copy
     */
    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class, 'book_copy_id');
    }
}