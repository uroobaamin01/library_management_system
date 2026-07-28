@extends('layouts.admin')

@section('title', 'Shelves Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Shelves</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <x-card title="Add New Shelf">
            <form action="{{ route('admin.shelves.store') }}" method="POST">
                @csrf
                <x-select name="rack_id" label="Parent Rack" :options="$racks->pluck('name', 'id')" :required="true" />
                <x-input name="name" label="Shelf Name" placeholder="e.g. Shelf Level 1" :required="true" />
                <x-input name="code" label="Shelf Code" placeholder="e.g. RACK-A1-S1" :required="true" />
                <x-input name="capacity" label="Capacity (Books)" type="number" value="50" :required="true" />
                <button type="submit" class="btn btn-primary w-100 mt-2"><i class="fa-solid fa-plus me-1"></i> Add Shelf</button>
            </form>
        </x-card>
    </div>
    <div class="col-md-8">
        <x-card title="Registered Shelves">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Shelf Name</th>
                            <th>Rack</th>
                            <th>Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shelves as $shelf)
                            <tr>
                                <td><code>{{ $shelf->code }}</code></td>
                                <td class="fw-semibold">{{ $shelf->name }}</td>
                                <td><span class="badge bg-light text-dark">{{ $shelf->rack->name }}</span></td>
                                <td>{{ $shelf->capacity }} books</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No shelves created.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $shelves->links('pagination::bootstrap-5') }}</div>
        </x-card>
    </div>
</div>
@endsection