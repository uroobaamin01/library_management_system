<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookFine;
use App\Models\BookRequest;
use App\Models\BookReservation;
use App\Models\BorrowTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class LibrarianDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'available_copies' => BookCopy::where('status', 'available')->count(),
            'issued_today' => BorrowTransaction::whereDate('issued_at', today())->count(),
            'returned_today' => BorrowTransaction::whereDate('returned_at', today())->count(),
            'pending_requests' => BookRequest::where('status', 'pending')->count(),
            'active_reservations' => BookReservation::where('status', 'pending')->count(),
            'total_students' => User::where('role', 'student')->where('status', 'active')->count(),
            'collected_fines' => BookFine::where('status', 'paid')->sum('amount'),
            'overdue_books' => BorrowTransaction::whereNull('returned_at')->where('due_date', '<', now())->count(),
            'recent_members' => User::where('role', 'student')->latest()->take(5)->get(),
        ];

        $recentlyIssued = BorrowTransaction::with(['student', 'bookCopy.book'])
            ->latest()
            ->take(5)
            ->get();

        $pendingRequests = BookRequest::with(['student', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('librarian.dashboard.index', compact('stats', 'recentlyIssued', 'pendingRequests'));
    }
}