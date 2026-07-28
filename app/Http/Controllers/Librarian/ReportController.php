<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookFine;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display reporting interface for issuing, returns, and fines.
     */
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $issues = BorrowTransaction::with(['student', 'bookCopy.book'])
            ->whereBetween('issued_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $returns = BorrowTransaction::with(['student', 'bookCopy.book'])
            ->whereBetween('returned_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $fineCollected = BookFine::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');

        return view('librarian.reports.index', compact('issues', 'returns', 'fineCollected', 'startDate', 'endDate'));
    }
}