<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display list of student accounts.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'student');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('librarian.students.index', compact('students'));
    }

    /**
     * Store new student account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student';

        User::create($validated);

        return redirect()->route('librarian.students.index')->with('success', 'Student registered successfully.');
    }

    /**
     * Show single student profile with borrow history.
     */
    public function show(User $student): View
    {
        if ($student->role !== 'student') {
            abort(404);
        }

        $student->load(['borrowTransactions.bookCopy.book', 'fines']);

        return view('librarian.students.show', compact('student'));
    }

    /**
     * Toggle active/suspended status of student account.
     */
    public function toggleStatus(User $student): RedirectResponse
    {
        if ($student->role !== 'student') {
            return back()->with('error', 'Invalid target user role.');
        }

        $newStatus = $student->status === 'active' ? 'inactive' : 'active';
        $student->update(['status' => $newStatus]);

        return redirect()->route('librarian.students.index')->with('success', "Student status changed to {$newStatus}.");
    }
}