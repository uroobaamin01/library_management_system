<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BorrowTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RenewBookController extends Controller
{
    /**
     * Display active transactions eligible for renewal.
     */
    public function index(): View
    {
        $eligibleTransactions = BorrowTransaction::with(['student', 'bookCopy.book'])
            ->where('status', 'issued')
            ->latest()
            ->paginate(15);

        return view('librarian.renew.index', compact('eligibleTransactions'));
    }

    /**
     * Extend due date for active transaction.
     */
    public function update(Request $request, BorrowTransaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'extension_days' => 'required|integer|min:1|max:30',
        ]);

        if ($transaction->status !== 'issued') {
            return back()->with('error', 'Only active issued transactions can be renewed.');
        }

        if ($transaction->renewal_count >= 3) {
            return back()->with('error', 'Maximum renewal limit (3 times) reached for this transaction.');
        }

        DB::beginTransaction();
        try {
            // Explicit Carbon parsing to ensure addDays method is recognized
            $currentDueDate = Carbon::parse($transaction->due_date);
            $newDueDate = $currentDueDate->addDays((int) $validated['extension_days']);

            $transaction->update([
                'due_date' => $newDueDate->toDateString(),
                'renewal_count' => $transaction->renewal_count + 1,
            ]);

            DB::commit();
            return redirect()->route('librarian.renew.index')->with('success', 'Book renewed successfully. New Due Date: ' . $newDueDate->format('Y-m-d'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to renew book: ' . $e->getMessage());
        }
    }
}