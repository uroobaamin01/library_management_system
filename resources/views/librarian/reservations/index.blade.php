@extends('librarian.layouts.app')

@section('title', 'Book Reservations')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-bookmark text-primary me-2"></i>Book Reservations</h4>
            <p class="text-muted small mb-0">View student book reservations and manage active holds.</p>
        </div>
    </div>

    <!-- Reservations List Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-list me-2 text-primary"></i>All Reservations</h6>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $reservations->total() }} Total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Copy Code</th>
                            <th scope="col">Reservation Date</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $reservation->student->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $reservation->student->email ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $reservation->book->title ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if($reservation->bookCopy)
                                        <span class="badge bg-light text-dark border">{{ $reservation->bookCopy->copy_code }}</span>
                                    @else
                                        <span class="text-muted small">Any Copy</span>
                                    @endif
                                </td>
                                <td>{{ $reservation->created_at ? $reservation->created_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td>
                                    @if($reservation->status === 'pending')
                                        <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                    @elseif($reservation->status === 'fulfilled')
                                        <span class="badge bg-success px-2 py-1">Fulfilled</span>
                                    @elseif($reservation->status === 'cancelled')
                                        <span class="badge bg-danger px-2 py-1">Cancelled</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">{{ ucfirst($reservation->status) }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($reservation->status === 'pending')
                                        <form action="{{ route('librarian.reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold" onclick="return confirm('Are you sure you want to cancel this reservation?')">
                                                <i class="fa-solid fa-ban me-1"></i>Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">No action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                    No book reservations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reservations->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection