<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookCopy;
use App\Models\BorrowTransaction;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IssueBookController extends Controller
{
    /**
     * Display issue book form and list of active transactions.
     */
    public function index(): View
    {
        $students = User::where('role', 'student')->where('status', 'active')->get();
        $availableCopies = BookCopy::with('book')->where('status', 'available')->get();
        $activeTransactions = BorrowTransaction::with(['student', 'bookCopy.book', 'issuer'])
            ->where('status', 'issued')
            ->latest()
            ->paginate(10);

        return view('librarian.issue.index', compact('students', 'availableCopies', 'activeTransactions'));
    }

    /**
     * Process issuing a book copy to a student.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'book_copy_id' => 'required|exists:book_copies,id',
            'due_days' => 'required|integer|min:1|max:60',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Verify student eligibility
            $student = User::where('id', $validated['student_id'])->where('role', 'student')->firstOrFail();
            if ($student->status !== 'active') {
                return back()->with('error', 'Selected student account is inactive/suspended.');
            }

            // Verify copy availability
            $copy = BookCopy::lockForUpdate()->findOrFail($validated['book_copy_id']);
            if ($copy->status !== 'available') {
                DB::rollBack();
                return back()->with('error', 'Selected book copy is currently not available.');
            }

            // Create Borrow Transaction
            BorrowTransaction::create([
                'student_id' => $student->id,
                'book_copy_id' => $copy->id,
                'issued_by' => Auth::id(),
                'issued_at' => now(),
                'due_date' => now()->addDays((int) $validated['due_days'])->toDateString(),
                'status' => 'issued',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Update copy status
            $copy->update(['status' => 'issued']);

            DB::commit();
            return redirect()->route('librarian.issue.index')->with('success', 'Book issued successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to issue book: ' . $e->getMessage());
        }
    }
}