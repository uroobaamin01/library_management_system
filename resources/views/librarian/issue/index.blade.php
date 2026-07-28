@extends('librarian.layouts.app')

@section('title', 'Issue Book')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Title Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-book-bookmark text-primary me-2"></i>Issue Book to Student</h4>
            <p class="text-muted small mb-0">Select a student and an available book copy to generate a new borrow transaction.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Issue Book Form Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-plus-circle me-2 text-primary"></i>New Issue Form</h6>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('librarian.issue.store') }}" method="POST">
                        @csrf

                        <!-- Student Select -->
                        <div class="mb-3">
                            <label for="student_id" class="form-label fw-semibold small">Select Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Choose Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Book Copy Select -->
                        <div class="mb-3">
                            <label for="book_copy_id" class="form-label fw-semibold small">Select Available Book Copy <span class="text-danger">*</span></label>
                            <select name="book_copy_id" id="book_copy_id" class="form-select @error('book_copy_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Choose Book Copy --</option>
                                @foreach($availableCopies as $copy)
                                    <option value="{{ $copy->id }}" {{ old('book_copy_id') == $copy->id ? 'selected' : '' }}>
                                        {{ $copy->book->title ?? 'Unknown Book' }} (Copy Code: {{ $copy->copy_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('book_copy_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Due Days Input -->
                        <div class="mb-4">
                            <label for="due_days" class="form-label fw-semibold small">Due Period (Days) <span class="text-danger">*</span></label>
                            <input type="number" name="due_days" id="due_days" class="form-control @error('due_days') is-invalid @enderror" value="{{ old('due_days', 14) }}" min="1" max="60" required>
                            <span class="form-text text-muted small">Standard borrow duration is usually 14 days.</span>
                            @error('due_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="fa-solid fa-hand-holding-hand me-2"></i>Issue Book Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Active Borrowed Transactions Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Currently Issued Books</h6>
                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ $activeTransactions->total() }} Active</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Student</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Copy Code</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col" class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeTransactions as $transaction)
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
                                        <td>{{ $transaction->created_at ? $transaction->created_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            @if($transaction->due_date)
                                                <span class="{{ \Carbon\Carbon::parse($transaction->due_date)->isPast() ? 'text-danger fw-bold' : 'text-dark' }}">
                                                    {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <span class="badge bg-warning text-dark px-2 py-1">Issued</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                            No actively issued books found right now.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($activeTransactions->hasPages())
                    <div class="card-footer bg-white py-3 border-top-0">
                        {{ $activeTransactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection