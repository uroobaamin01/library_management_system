@extends('student.layouts.app')

@section('title', 'Student Dashboard - Overview')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Welcome back, {{ Auth::user()->name }}!</h3>
        <p class="text-muted small">Here is a summary of your active borrowing activities.</p>
    </div>
    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-search me-1"></i> Browse Books Catalog</a>
</div>

<!-- Key Stat Widgets -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Active Borrows</span>
                    <h4 class="fw-bold mb-0 mt-1">{{ $currentBorrows->count() }}</h4>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle"><i class="fa-solid fa-book fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Pending Requests</span>
                    <h4 class="fw-bold mb-0 mt-1">{{ $pendingRequests->count() }}</h4>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-circle"><i class="fa-solid fa-hourglass-half fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Reservations</span>
                    <h4 class="fw-bold mb-0 mt-1">{{ $activeReservations->count() }}</h4>
                </div>
                <div class="bg-info-subtle text-info p-3 rounded-circle"><i class="fa-solid fa-bookmark fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Unpaid Fines</span>
                    <h4 class="fw-bold mb-0 mt-1 text-danger">${{ number_format($unpaidFines, 2) }}</h4>
                </div>
                <div class="bg-danger-subtle text-danger p-3 rounded-circle"><i class="fa-solid fa-receipt fa-lg"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Active Borrows Table (Synced Live from Librarian Issues) -->
<div class="card border-0 shadow-sm bg-white mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0">Currently Issued Books</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small">
                <tr>
                    <th>Book Title</th>
                    <th>Issued Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($currentBorrows as $transaction)
                    <tr>
                        <td class="fw-semibold">{{ $transaction->bookCopy->book->title ?? 'N/A' }}</td>
                        <td>{{ $transaction->issued_at ? \Carbon\Carbon::parse($transaction->issued_at)->format('M d, Y') : '-' }}</td>
                        <td>{{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') : '-' }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                                <span class="badge bg-danger">Overdue</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No books currently issued to your account.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection