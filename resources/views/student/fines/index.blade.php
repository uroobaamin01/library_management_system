@extends('frontend.layouts.app')

@section('title', 'My Fines - UniLibrary')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1"><i class="fa-solid fa-receipt me-2"></i>My Library Fines</h3>
            <p class="text-muted small mb-0">Track outstanding fine amounts and payment history.</p>
        </div>
        <div class="bg-white border rounded-3 px-3 py-2 text-end shadow-sm">
            <span class="text-muted small d-block">Total Unpaid Fine</span>
            <span class="fw-bold text-danger fs-5">${{ number_format($totalUnpaid, 2) }}</span>
        </div>
    </div>

    <div class="card card-custom border-0 shadow-sm bg-white p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Reason / Details</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($fines as $index => $fine)
                        <tr>
                            <td>{{ $fines->firstItem() + $index }}</td>
                            <td class="fw-semibold">
                                {{ $fine->borrowTransaction->bookCopy->book->title ?? 'N/A' }}
                            </td>
                            <td>{{ $fine->reason ?? 'Late Return Penalty' }}</td>
                            <td class="fw-bold">${{ number_format($fine->amount, 2) }}</td>
                            <td>
                                @if($fine->status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>{{ $fine->created_at ? $fine->created_at->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No fine records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $fines->links() }}
        </div>
    </div>
</div>
@endsection