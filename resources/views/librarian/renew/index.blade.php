@extends('librarian.layouts.app')

@section('title', 'Renew Book')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-clock text-warning me-2"></i>Renew / Extend Book Due Date</h4>
            <p class="text-muted small mb-0">Extend the due date for currently issued active book transactions.</p>
        </div>
    </div>

    <!-- Active Issued Transactions Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-list-check me-2 text-primary"></i>Active Borrow Transactions</h6>
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ $eligibleTransactions->total() }} Eligible for Renewal</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Copy Code</th>
                            <th scope="col">Current Due Date</th>
                            <th scope="col">Extend Days</th>
                            <th scope="col" class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eligibleTransactions as $transaction)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $transaction->student->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $transaction->student->email ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $transaction->bookCopy->book->title ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $transaction->bookCopy->copy_code ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if($transaction->due_date)
                                        <span class="{{ \Carbon\Carbon::parse($transaction->due_date)->isPast() ? 'text-danger fw-bold' : 'text-dark' }}">
                                            {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('librarian.renew.update', $transaction->id) }}" method="POST" id="renew-form-{{ $transaction->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm" style="max-width: 140px;">
                                            <input type="number" name="extension_days" class="form-control" value="7" min="1" max="30" required>
                                            <span class="input-group-text">days</span>
                                        </div>
                                    </form>
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="submit" form="renew-form-{{ $transaction->id }}" class="btn btn-sm btn-warning text-dark fw-semibold">
                                        <i class="fa-solid fa-arrows-rotate me-1"></i>Extend Date
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                    No active borrowed books eligible for renewal found right now.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($eligibleTransactions->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $eligibleTransactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection