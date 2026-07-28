@extends('layouts.admin')

@section('title', 'Publishers')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Publishers</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <x-card title="Add Publisher">
            <form action="{{ route('admin.publishers.store') }}" method="POST">
                @csrf
                <x-input name="name" label="Publisher Name" :required="true" />
                <x-input name="email" label="Email" type="email" />
                <x-input name="phone" label="Phone" />
                <x-textarea name="address" label="Address" />
                <button type="submit" class="btn btn-primary w-100 mt-2"><i class="fa-solid fa-plus me-1"></i> Add Publisher</button>
            </form>
        </x-card>
    </div>
    <div class="col-md-8">
        <x-card title="Publishers List">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Contact Info</th>
                            <th>Books</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publishers as $publisher)
                            <tr>
                                <td class="fw-semibold">{{ $publisher->name }}</td>
                                <td>
                                    <div class="small">{{ $publisher->email ?? 'No email' }}</div>
                                    <div class="text-muted small">{{ $publisher->phone ?? '' }}</div>
                                </td>
                                <td><span class="badge bg-secondary">{{ $publisher->books_count }}</span></td>
                                <td class="text-end">
                                    <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove publisher?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No publishers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $publishers->links('pagination::bootstrap-5') }}</div>
        </x-card>
    </div>
</div>
@endsection