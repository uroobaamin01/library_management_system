<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // Currently Borrowed Books
        $currentBorrows = BorrowTransaction::with(['bookCopy.book'])
            ->where('student_id', $studentId)
            ->whereNull('returned_at')
            ->latest()
            ->get();

        // Overdue Books Count
        $overdueCount = BorrowTransaction::where('student_id', $studentId)
            ->whereNull('returned_at')
            ->where('due_date', '<', now())
            ->count();

        // Pending Book Requests / Reservations
        $pendingRequests = BookRequest::with('book')
            ->where('student_id', $studentId)
            ->where('status', 'pending')
            ->get();

        // Active Reservations (View Fix)
        $activeReservations = $pendingRequests;

        // Safely check if fine_amount column exists in borrow_transactions
        $unpaidFines = 0.00;
        if (Schema::hasColumn('borrow_transactions', 'fine_amount')) {
            $unpaidFines = BorrowTransaction::where('student_id', $studentId)
                ->whereNull('returned_at')
                ->sum('fine_amount') ?? 0.00;
        }

        return view('student.dashboard', compact(
            'currentBorrows', 
            'overdueCount', 
            'pendingRequests', 
            'activeReservations', 
            'unpaidFines'
        ));
    }
}