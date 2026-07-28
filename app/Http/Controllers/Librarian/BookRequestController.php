<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookCopy;
use App\Models\BookRequest;
use App\Models\BorrowTransaction;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookRequestController extends Controller
{
    /**
     * Display listing of pending and historical book requests.
     */
    public function index(): View
    {
        $pendingRequests = BookRequest::with(['student', 'book'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $processedRequests = BookRequest::with(['student', 'book', 'processor'])
            ->where('status', '!=', 'pending')
            ->latest()
            ->paginate(10);

        return view('librarian.requests.index', compact('pendingRequests', 'processedRequests'));
    }

    /**
     * Approve book request and automatically issue an available copy.
     */
    public function approve(Request $request, BookRequest $bookRequest): RedirectResponse
    {
        if ($bookRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        DB::beginTransaction();
        try {
            $availableCopy = BookCopy::where('book_id', $bookRequest->book_id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$availableCopy) {
                DB::rollBack();
                return back()->with('error', 'No available physical copy for this book at the moment.');
            }

            // Create transaction
            BorrowTransaction::create([
                'student_id' => $bookRequest->student_id,
                'book_copy_id' => $availableCopy->id,
                'issued_by' => Auth::id(),
                'issued_at' => now(),
                'due_date' => now()->addDays(14)->toDateString(),
                'status' => 'issued',
                'notes' => 'Issued automatically via Student Book Request #' . $bookRequest->id,
            ]);

            // Update Copy
            $availableCopy->update(['status' => 'issued']);

            // Update Request Status
            $bookRequest->update([
                'status' => 'approved',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('librarian.requests.index')->with('success', 'Book request approved and issued successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    /**
     * Reject a pending book request with reason.
     */
    public function reject(Request $request, BookRequest $bookRequest): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        if ($bookRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $bookRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('librarian.requests.index')->with('success', 'Book request rejected.');
    }
}