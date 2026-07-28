<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookFine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFineController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // Fetch fines using student_id
        $fines = BookFine::with(['borrowTransaction.bookCopy.book'])
            ->where('student_id', $studentId)
            ->latest()
            ->paginate(10);

        $totalUnpaid = BookFine::where('student_id', $studentId)
            ->where('status', 'unpaid')
            ->sum('amount');

        return view('student.fines.index', compact('fines', 'totalUnpaid'));
    }
}