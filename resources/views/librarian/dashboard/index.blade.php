@extends('librarian.layouts.app')

@section('title', 'Librarian Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Librarian' }}!</h4>
        <p class="text-muted small mb-0">Here is what is happening across the library today.</p>
    </div>
    <a href="{{ route('librarian.issue.index') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Issue New Book
    </a>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-start border-4 border-primary p-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <span class="text-muted small d-block">Total Catalog Books</span>
                    <h3 class="fw-bold mb-0">{{ $stats['total_books'] ?? 0 }}</h3>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                    <i class="fa-solid fa-book fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-start border-4 border-success p-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <span class="text-muted small d-block">Available Copies</span>
                    <h3 class="fw-bold mb-0">{{ $stats['available_copies'] ?? 0 }}</h3>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-circle">
                    <i class="fa-solid fa-book-open fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-start border-4 border-info p-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <span class="text-muted small d-block">Issued Today</span>
                    <h3 class="fw-bold mb-0">{{ $stats['issued_today'] ?? 0 }}</h3>
                </div>
                <div class="bg-info-subtle text-info p-3 rounded-circle">
                    <i class="fa-solid fa-arrow-up-from-bracket fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card shadow-sm border-start border-4 border-warning p-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <span class="text-muted small d-block">Returned Today</span>
                    <h3 class="fw-bold mb-0">{{ $stats['returned_today'] ?? 0 }}</h3>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                    <i class="fa-solid fa-arrow-down-to-bracket fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Graphs Section -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-3">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Monthly Issue & Return Overview</h6>
            <canvas id="circulationChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-3">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-pie-chart me-2 text-info"></i>Pending Workflow Queue</h6>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span><i class="fa-solid fa-inbox me-2 text-warning"></i>Pending Requests</span>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $stats['pending_requests'] ?? 0 }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span><i class="fa-solid fa-clock me-2 text-info"></i>Active Holds</span>
                    <span class="badge bg-info rounded-pill">{{ $stats['active_reservations'] ?? 0 }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span><i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i>Overdue Transactions</span>
                    <span class="badge bg-danger rounded-pill">{{ $stats['overdue_books'] ?? 0 }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span><i class="fa-solid fa-hand-holding-dollar me-2 text-success"></i>Collected Fines</span>
                    <span class="fw-bold text-success">${{ number_format($stats['collected_fines'] ?? 0, 2) }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Data Tables -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom fw-bold small py-3">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Recently Issued Books
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Book</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentlyIssued ?? [] as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->student->name ?? 'N/A' }}</td>
                                <td>{{ $item->bookCopy->book->title ?? ($item->book->title ?? 'N/A') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ isset($item->due_date) ? \Carbon\Carbon::parse($item->due_date)->format('Y-m-d') : 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No recent issue transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom fw-bold small py-3">
                <i class="fa-solid fa-inbox me-2 text-warning"></i>Pending Student Requests
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Requested Book</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests ?? [] as $req)
                            <tr>
                                <td class="fw-semibold">{{ $req->student->name ?? 'N/A' }}</td>
                                <td>{{ $req->book->title ?? 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('librarian.requests.index') }}" class="btn btn-outline-primary btn-sm px-3">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No pending book requests.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const canvas = document.getElementById('circulationChart');
        if (canvas && typeof Chart !== 'undefined') {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [
                        {
                            label: 'Books Issued',
                            data: [12, 19, 15, 25, 22, 30, {{ $stats['issued_today'] ?? 0 }}],
                            borderColor: '#0284c7',
                            backgroundColor: 'rgba(2, 132, 199, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Books Returned',
                            data: [8, 15, 10, 20, 18, 26, {{ $stats['returned_today'] ?? 0 }}],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        }
    });
</script>
@endpush