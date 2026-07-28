<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentBorrowController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // History of issued and returned transactions (student_id fixed)
        $transactions = BorrowTransaction::with(['bookCopy.book'])
            ->where('student_id', $studentId)
            ->latest()
            ->paginate(10);

        // All Book Requests made by student (student_id fixed)
        $requests = BookRequest::with('book')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('student.borrows.index', compact('transactions', 'requests'));
    }
}