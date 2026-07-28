<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookFine;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FineController extends Controller
{
    /**
     * List all pending and paid fines.
     */
    public function index(): View
    {
        $fines = BookFine::with(['student', 'borrowTransaction.bookCopy.book', 'collector'])
            ->latest()
            ->paginate(15);

        return view('librarian.fines.index', compact('fines'));
    }

    /**
     * Receive fine payment from student.
     */
    public function markAsPaid(Request $request, BookFine $fine): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:cash,card,online',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($fine->status === 'paid') {
            return back()->with('error', 'Fine is already marked as paid.');
        }

        DB::beginTransaction();
        try {
            $fine->update([
                'status' => 'paid',
                'paid_at' => now(),
                'received_by' => Auth::id(),
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('librarian.fines.index')->with('success', 'Fine payment received successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to collect payment: ' . $e->getMessage());
        }
    }
}