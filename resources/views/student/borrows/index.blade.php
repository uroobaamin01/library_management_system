@extends('frontend.layouts.app')

@section('title', 'My Borrows & Requests - UniLibrary')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1"><i class="fa-solid fa-book-bookmark me-2"></i>My Borrow History & Requests</h3>
            <p class="text-muted small mb-0">Manage your issued books and track pending book requests.</p>
        </div>
        <a href="{{ route('books.index') }}" class="btn btn-theme btn-sm"><i class="fa-solid fa-search me-1"></i> Browse Books</a>
    </div>

    <!-- Active & Past Borrow Transactions -->
    <div class="card card-custom border-0 shadow-sm bg-white mb-5 p-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-clock-rotate-left me-2"></i>Issued Books History</h5>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Returned Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $transactions->firstItem() + $index }}</td>
                            <td class="fw-semibold">
                                {{ $transaction->bookCopy->book->title ?? 'N/A' }}
                            </td>
                            <td>{{ $transaction->issue_date ? \Carbon\Carbon::parse($transaction->issue_date)->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $transaction->due_date ? \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                @if($transaction->returned_at)
                                    <span class="text-success">{{ \Carbon\Carbon::parse($transaction->returned_at)->format('M d, Y') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->returned_at)
                                    <span class="badge bg-success">Returned</span>
                                @elseif($transaction->due_date && \Carbon\Carbon::parse($transaction->due_date)->isPast())
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-primary">Issued</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No borrow transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Book Requests Section -->
    <div class="card card-custom border-0 shadow-sm bg-white p-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="fa-solid fa-paper-plane me-2"></i>Book Requests</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Requested Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($requests as $index => $req)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $req->book->title ?? 'N/A' }}</td>
                            <td>{{ $req->created_at ? $req->created_at->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                @if($req->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($req->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No active book requests.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection