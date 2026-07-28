<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReservationController extends Controller
{
    public function index()
    {
        $reservations = BookReservation::with('book')
            ->where('student_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.reservations.index', compact('reservations'));
    }

    public function store(Request $request, Book $book)
    {
        $studentId = Auth::id();

        $existingReservation = BookReservation::where('student_id', $studentId)
            ->where('book_id', $book->id)
            ->where('status', 'pending')
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'You already have a pending reservation for this book.');
        }

        BookReservation::create([
            'student_id' => $studentId,
            'book_id' => $book->id,
            'status' => 'pending',
            'reserved_at' => now(),
        ]);

        return back()->with('success', 'Book reservation requested successfully!');
    }

    public function cancel(BookReservation $reservation)
    {
        if ($reservation->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}