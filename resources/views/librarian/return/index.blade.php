@extends('librarian.layouts.app')

@section('title', 'Return Book')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-rotate-left text-success me-2"></i>Return Book</h4>
            <p class="text-muted small mb-0">Select an issued transaction to mark the book copy as returned and handle fines.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Return Process Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-square-check me-2 text-success"></i>Process Return Form</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('librarian.return.store') }}" method="POST">
                        @csrf

                        <!-- Issued Book Transaction Select -->
                        <div class="mb-3">
                            <label for="borrow_transaction_id" class="form-label fw-semibold small">Select Issued Transaction <span class="text-danger">*</span></label>
                            <select name="borrow_transaction_id" id="borrow_transaction_id" class="form-select @error('borrow_transaction_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Choose Issued Book --</option>
                                @foreach($borrowedBooks as $transaction)
                                    <option value="{{ $transaction->id }}" {{ old('borrow_transaction_id') == $transaction->id ? 'selected' : '' }}>
                                        {{ $transaction->student->name ?? 'Student' }} - {{ $transaction->bookCopy->book->title ?? 'Book' }} (Code: {{ $transaction->bookCopy->copy_code ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('borrow_transaction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fine per day -->
                        <div class="mb-3">
                            <label for="fine_per_day" class="form-label fw-semibold small">Fine Rate Per Day (if overdue)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" step="0.01" name="fine_per_day" id="fine_per_day" class="form-control @error('fine_per_day') is-invalid @enderror" value="{{ old('fine_per_day', 10.00) }}" min="0">
                            </div>
                            <span class="form-text text-muted small">Default fine calculation rate for overdue days.</span>
                            @error('fine_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes / Remarks -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold small">Remarks / Book Condition</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="e.g. Good condition, minor wear, fine collected...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-semibold py-2">
                            <i class="fa-solid fa-circle-check me-2"></i>Confirm Return
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Return History Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-history me-2 text-primary"></i>Recent Return History</h6>
                    <span class="badge bg-success rounded-pill px-3 py-2">{{ $returnHistory->total() }} Returned</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Student</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Returned Date</th>
                                    <th scope="col">Fine</th>
                                    <th scope="col" class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($returnHistory as $history)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold text-dark">{{ $history->student->name ?? 'N/A' }}</div>
                                            <div class="text-muted small">{{ $history->student->email ?? '' }}</div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $history->bookCopy->book->title ?? 'N/A' }}</span>
                                            <div class="text-muted small">Code: {{ $history->bookCopy->copy_code ?? 'N/A' }}</div>
                                        </td>
                                        <td>{{ $history->returned_at ? \Carbon\Carbon::parse($history->returned_at)->format('M d, Y') : ($history->updated_at ? $history->updated_at->format('M d, Y') : 'N/A') }}</td>
                                        <td>
                                            @if(($history->fine_amount ?? 0) > 0)
                                                <span class="badge bg-danger">Rs. {{ number_format($history->fine_amount, 2) }}</span>
                                            @else
                                                <span class="badge bg-light text-dark border">No Fine</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <span class="badge bg-success px-2 py-1">Returned</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                            No returned transactions found yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($returnHistory->hasPages())
                    <div class="card-footer bg-white py-3 border-top-0">
                        {{ $returnHistory->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection