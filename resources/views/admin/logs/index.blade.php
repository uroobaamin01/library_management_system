@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Audit Logs</li>
@endsection

@section('content')
<x-card title="System Activity & Audit Logs">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="fw-semibold">{{ $log->user->name ?? 'System' }}</td>
                        <td><span class="badge bg-dark">{{ $log->action }}</span></td>
                        <td><span class="badge bg-light text-dark">{{ $log->module }}</span></td>
                        <td>{{ $log->description }}</td>
                        <td><code>{{ $log->ip_address }}</code></td>
                        <td class="small text-muted">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No audit logs logged yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection