@extends('librarian.layouts.app')

@section('title', 'Library Reports')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-chart-line text-primary me-2"></i>Library Reports</h4>
            <p class="text-muted small mb-0">Overview of book issues, returns, and fine collections.</p>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form action="{{ route('librarian.reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-semibold small">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-semibold small">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fa-solid fa-filter me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle me-3">
                        <i class="fa-solid fa-book-bookmark fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Books Issued</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ count($issues) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success-subtle text-success p-3 rounded-circle me-3">
                        <i class="fa-solid fa-rotate-left fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Books Returned</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ count($returns) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 bg-white p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle me-3">
                        <i class="fa-solid fa-sack-dollar fa-xl"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Fines Collected</span>
                        <h3 class="fw-bold mb-0 text-danger">Rs. {{ number_format($fineCollected, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Tabs -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom-0">
            <ul class="nav nav-tabs card-header-tabs" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="issues-tab" data-bs-toggle="tab" data-bs-target="#issues-pane" type="button" role="tab">
                        <i class="fa-solid fa-arrow-up-from-bracket me-2 text-primary"></i>Issued Books ({{ count($issues) }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="returns-tab" data-bs-toggle="tab" data-bs-target="#returns-pane" type="button" role="tab">
                        <i class="fa-solid fa-arrow-down-to-bracket me-2 text-success"></i>Returned Books ({{ count($returns) }})
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="reportTabsContent">
                <!-- Issued Tab -->
                <div class="tab-pane fade show active" id="issues-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Student</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Copy Code</th>
                                    <th scope="col">Issued Date</th>
                                    <th scope="col" class="pe-4 text-end">Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($issues as $issue)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold text-dark">{{ $issue->student->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>{{ $issue->bookCopy->book->title ?? 'N/A' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $issue->bookCopy->copy_code ?? 'N/A' }}</span></td>
                                        <td>{{ $issue->issued_at ? \Carbon\Carbon::parse($issue->issued_at)->format('M d, Y') : 'N/A' }}</td>
                                        <td class="pe-4 text-end">{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('M d, Y') : 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No issues found in this date range.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Returned Tab -->
                <div class="tab-pane fade" id="returns-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Student</th>
                                    <th scope="col">Book Title</th>
                                    <th scope="col">Copy Code</th>
                                    <th scope="col">Returned Date</th>
                                    <th scope="col" class="pe-4 text-end">Fine Collected</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($returns as $return)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold text-dark">{{ $return->student->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>{{ $return->bookCopy->book->title ?? 'N/A' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $return->bookCopy->copy_code ?? 'N/A' }}</span></td>
                                        <td>{{ $return->returned_at ? \Carbon\Carbon::parse($return->returned_at)->format('M d, Y') : 'N/A' }}</td>
                                        <td class="pe-4 text-end">
                                            @if(($return->fine_amount ?? 0) > 0)
                                                <span class="badge bg-danger">Rs. {{ number_format($return->fine_amount, 2) }}</span>
                                            @else
                                                <span class="badge bg-light text-dark border">No Fine</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No returns found in this date range.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection