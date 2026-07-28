@extends('layouts.admin')

@section('title', 'Racks Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Racks</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <x-card title="Add New Rack">
            <form action="{{ route('admin.racks.store') }}" method="POST">
                @csrf
                <x-input name="name" label="Rack Name" placeholder="e.g. Science Rack A" :required="true" />
                <x-input name="code" label="Rack Code" placeholder="e.g. RACK-A1" :required="true" />
                <x-textarea name="description" label="Description" />
                <button type="submit" class="btn btn-primary w-100 mt-2"><i class="fa-solid fa-plus me-1"></i> Add Rack</button>
            </form>
        </x-card>
    </div>
    <div class="col-md-8">
        <x-card title="Physical Racks List">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Shelves Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($racks as $rack)
                            <tr>
                                <td><code>{{ $rack->code }}</code></td>
                                <td class="fw-semibold">{{ $rack->name }}</td>
                                <td><span class="badge bg-secondary">{{ $rack->shelves_count }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No storage racks defined.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $racks->links('pagination::bootstrap-5') }}</div>
        </x-card>
    </div>
</div>
@endsection