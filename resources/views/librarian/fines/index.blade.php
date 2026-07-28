@extends('librarian.layouts.app')

@section('title', 'Manage Fines')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-receipt text-danger me-2"></i>Library Fines & Payments</h4>
            <p class="text-muted small mb-0">Track student overdue fines and receive payment entries.</p>
        </div>
    </div>

    <!-- Fines Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-list-check me-2 text-primary"></i>Fine Records</h6>
            <span class="badge bg-danger rounded-pill px-3 py-2">{{ $fines->total() }} Total Fines</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student</th>
                            <th scope="col">Book Info</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Collected By</th>
                            <th scope="col" class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fines as $fine)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $fine->student->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $fine->student->email ?? '' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $fine->borrowTransaction->bookCopy->book->title ?? 'N/A' }}</div>
                                    <div class="text-muted small">Copy Code: {{ $fine->borrowTransaction->bookCopy->copy_code ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold text-danger">Rs. {{ number_format($fine->amount, 2) }}</span>
                                </td>
                                <td>
                                    @if($fine->status === 'paid')
                                        <span class="badge bg-success px-2 py-1"><i class="fa-solid fa-check me-1"></i>Paid</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="fa-solid fa-hourglass-half me-1"></i>Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($fine->collector)
                                        <span class="text-dark small">{{ $fine->collector->name }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($fine->status !== 'paid')
                                        <button type="button" class="btn btn-sm btn-success fw-semibold" data-bs-toggle="modal" data-bs-target="#payFineModal-{{ $fine->id }}">
                                            <i class="fa-solid fa-money-bill-wave me-1"></i>Receive Payment
                                        </button>

                                        <!-- Receive Payment Modal -->
                                        <div class="modal fade text-start" id="payFineModal-{{ $fine->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-bottom-0">
                                                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-wallet text-success me-2"></i>Collect Fine Payment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('librarian.fines.pay', $fine->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="alert alert-light border mb-3">
                                                                <div class="small text-muted">Student: <strong>{{ $fine->student->name ?? 'N/A' }}</strong></div>
                                                                <div class="small text-muted">Amount Due: <strong class="text-danger">Rs. {{ number_format($fine->amount, 2) }}</strong></div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold small">Payment Method <span class="text-danger">*</span></label>
                                                                <select name="payment_method" class="form-select" required>
                                                                    <option value="cash" selected>Cash</option>
                                                                    <option value="card">Card</option>
                                                                    <option value="online">Online Transfer</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold small">Notes / Remarks</label>
                                                                <textarea name="notes" class="form-control" rows="2" placeholder="Optional payment receipt notes..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-success fw-semibold"><i class="fa-solid fa-check me-1"></i>Confirm Paid</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small"><i class="fa-solid fa-lock me-1"></i>Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-receipt fa-2x mb-2 d-block text-secondary"></i>
                                    No fine records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($fines->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $fines->links() }}
            </div>
        @endif
    </div>
</div>
@endsection