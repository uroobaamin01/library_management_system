@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<!-- Dashboard Metrics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase">Total Books</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($metrics['total_books']) }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                    <i class="fa-solid fa-book fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase">Available Copies</span>
                    <h3 class="fw-bold text-success mb-0 mt-1">{{ number_format($metrics['available_copies']) }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                    <i class="fa-solid fa-check-double fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase">Issued Copies</span>
                    <h3 class="fw-bold text-info mb-0 mt-1">{{ number_format($metrics['issued_books']) }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                    <i class="fa-solid fa-hand-holding-hand fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase">Lost/Damaged</span>
                    <h3 class="fw-bold text-danger mb-0 mt-1">{{ number_format($metrics['lost_books']) }}</h3>
                </div>
                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
                    <i class="fa-solid fa-triangle-exclamation fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Charts & Metrics -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <x-card title="Books Per Category">
            <canvas id="categoryChart" height="110"></canvas>
        </x-card>
    </div>
    <div class="col-lg-4">
        <x-card title="Physical Copy Status">
            <canvas id="statusChart" height="240"></canvas>
        </x-card>
    </div>
</div>

<!-- Recent Books & System Activities -->
<div class="row g-4">
    <div class="col-lg-7">
        <x-card title="Recently Added Books">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBooks as $book)
                            <tr>
                                <td class="fw-semibold">{{ $book->title }}</td>
                                <td><span class="badge bg-light text-dark">{{ $book->category->name }}</span></td>
                                <td>{{ $book->author->name }}</td>
                                <td>${{ number_format($book->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No recent books found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
    <div class="col-lg-5">
        <x-card title="Recent Audit Logs">
            <ul class="list-group list-group-flush">
                @forelse($latestActivities as $log)
                    <li class="list-group-list-item px-0 py-2 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold small">{{ $log->action }}</div>
                            <div class="text-muted small">{{ $log->description }}</div>
                        </div>
                        <span class="text-muted" style="font-size: 0.75rem;">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="text-muted small">No recent logs.</li>
                @endforelse
            </ul>
        </x-card>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        const catCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['books_per_category']['labels']) !!},
                datasets: [{
                    label: 'Number of Books',
                    data: {!! json_encode($chartData['books_per_category']['data']) !!},
                    backgroundColor: '#3b82f6'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartData['copy_status_distribution']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chartData['copy_status_distribution']['data']) !!},
                    backgroundColor: ['#22c55e', '#3b82f6', '#eab308', '#ef4444', '#64748b']
                }]
            },
            options: { responsive: true }
        });
    });
</script>
@endpush