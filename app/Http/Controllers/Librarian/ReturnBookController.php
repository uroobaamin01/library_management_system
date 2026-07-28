<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookFine;
use App\Models\BorrowTransaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReturnBookController extends Controller
{
    /**
     * Display returned transactions and active borrowed books list.
     */
    public function index(): View
    {
        $borrowedBooks = BorrowTransaction::with(['student', 'bookCopy.book'])
            ->where('status', 'issued')
            ->get();

        $returnHistory = BorrowTransaction::with(['student', 'bookCopy.book', 'receiver'])
            ->where('status', 'returned')
            ->latest()
            ->paginate(10);

        return view('librarian.return.index', compact('borrowedBooks', 'returnHistory'));
    }

    /**
     * Process return of a borrowed book and calculate fine if overdue.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'borrow_transaction_id' => 'required|exists:borrow_transactions,id',
            'fine_per_day' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $transaction = BorrowTransaction::with('bookCopy')->lockForUpdate()->findOrFail($validated['borrow_transaction_id']);

            if ($transaction->status === 'returned') {
                DB::rollBack();
                return back()->with('error', 'This book has already been returned.');
            }

            $returnedAt = now();
            $transaction->returned_at = $returnedAt;
            $transaction->returned_by = Auth::id();
            $transaction->status = 'returned';
            if (!empty($validated['notes'])) {
                $transaction->notes = $transaction->notes . "\nReturn Note: " . $validated['notes'];
            }
            $transaction->save();

            // Free the copy status
            if ($transaction->bookCopy) {
                $transaction->bookCopy->update(['status' => 'available']);
            }

            // Calculate fine if returned after due_date
            $dueDate = $transaction->due_date;
            if ($returnedAt->toDateString() > $dueDate->toDateString()) {
                $overdueDays = $dueDate->diffInDays($returnedAt);
                $rate = $validated['fine_per_day'] ?? 10.00; // default 10 per day
                $fineAmount = $overdueDays * $rate;

                BookFine::create([
                    'borrow_transaction_id' => $transaction->id,
                    'student_id' => $transaction->student_id,
                    'amount' => $fineAmount,
                    'overdue_days' => $overdueDays,
                    'status' => 'pending',
                    'notes' => "Auto fine generated for {$overdueDays} days overdue.",
                ]);
            }

            DB::commit();
            return redirect()->route('librarian.return.index')->with('success', 'Book returned and processed successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to return book: ' . $e->getMessage());
        }
    }
}