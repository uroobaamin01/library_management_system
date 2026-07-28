<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\BookReservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display active and historical book reservations.
     */
    public function index(): View
    {
        $reservations = BookReservation::with(['student', 'book', 'bookCopy'])
            ->latest()
            ->paginate(15);

        return view('librarian.reservations.index', compact('reservations'));
    }

    /**
     * Cancel active reservation.
     */
    public function cancel(BookReservation $reservation): RedirectResponse
    {
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be cancelled.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('librarian.reservations.index')->with('success', 'Reservation cancelled.');
    }
}