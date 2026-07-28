@extends('frontend.layouts.app')

@section('title', 'My Book Reservations - UniLibrary')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1"><i class="fa-solid fa-bookmark me-2"></i>My Book Reservations</h3>
            <p class="text-muted small mb-0">View and track all your active and previous book reservation requests.</p>
        </div>
        <a href="{{ route('books.index') }}" class="btn btn-theme btn-sm"><i class="fa-solid fa-search me-1"></i> Browse Books</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Reservations List Card -->
    <div class="card card-custom border-0 shadow-sm bg-white p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Reserved Date</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($reservations as $index => $reservation)
                        <tr>
                            <td>{{ $reservations->firstItem() + $index }}</td>
                            <td class="fw-semibold">
                                {{ $reservation->book->title ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $reservation->reserved_at ? \Carbon\Carbon::parse($reservation->reserved_at)->format('M d, Y - h:i A') : ($reservation->created_at ? $reservation->created_at->format('M d, Y') : 'N/A') }}
                            </td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($reservation->status === 'approved' || $reservation->status === 'fulfilled')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-secondary">Cancelled</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($reservation->status === 'pending')
                                    <form action="{{ route('student.reservations.cancel', $reservation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                                            <i class="fa-solid fa-xmark me-1"></i> Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No book reservations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection