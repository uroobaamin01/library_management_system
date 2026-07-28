@extends('librarian.layouts.app')

@section('title', 'Book Requests')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-code-pull-request text-primary me-2"></i>Student Book Requests</h4>
            <p class="text-muted small mb-0">Review and approve or reject pending book borrow requests from students.</p>
        </div>
    </div>

    <!-- Pending Requests Section -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-hourglass-half me-2 text-warning"></i>Pending Requests</h6>
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ count($pendingRequests) }} Pending</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student</th>
                            <th scope="col">Requested Book</th>
                            <th scope="col">Request Date</th>
                            <th scope="col" class="pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests as $requestItem)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $requestItem->student->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $requestItem->student->email ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $requestItem->book->title ?? 'N/A' }}</span>
                                    <div class="text-muted small">ISBN: {{ $requestItem->book->isbn ?? 'N/A' }}</div>
                                </td>
                                <td>{{ $requestItem->created_at ? $requestItem->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <!-- Approve Request -->
                                        <form action="{{ route('librarian.requests.approve', $requestItem->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                                <i class="fa-solid fa-check me-1"></i>Approve & Issue
                                            </button>
                                        </form>

                                        <!-- Reject Request -->
                                        <form action="{{ route('librarian.requests.reject', $requestItem->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Are you sure you want to reject this request?')">
                                                <i class="fa-solid fa-xmark me-1"></i>Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                    No pending book requests at the moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Processed Requests History Section -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Processed Requests History</h6>
            <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $processedRequests->total() }} Total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student</th>
                            <th scope="col">Book</th>
                            <th scope="col">Processed By</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="pe-4 text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($processedRequests as $processed)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $processed->student->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $processed->student->email ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $processed->book->title ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $processed->processor->name ?? 'System/Librarian' }}</span>
                                </td>
                                <td>{{ $processed->updated_at ? $processed->updated_at->format('M d, Y') : 'N/A' }}</td>
                                <td class="pe-4 text-end">
                                    @if($processed->status === 'approved')
                                        <span class="badge bg-success px-2 py-1"><i class="fa-solid fa-check me-1"></i>Approved</span>
                                    @elseif($processed->status === 'rejected')
                                        <span class="badge bg-danger px-2 py-1"><i class="fa-solid fa-xmark me-1"></i>Rejected</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">{{ ucfirst($processed->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                    No request history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($processedRequests->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $processedRequests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection