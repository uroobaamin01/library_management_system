@extends('layouts.admin')

@section('title', 'Authors')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Authors</li>
@endsection

@section('content')
<x-card title="Author Catalog">
    <x-slot name="headerActions">
        <a href="{{ route('admin.authors.create') }}" class="btn btn-primary btn-sm fw-semibold">
            <i class="fa-solid fa-plus me-1"></i> Add Author
        </a>
    </x-slot>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Books Authored</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                    <tr>
                        <td class="fw-semibold">{{ $author->name }}</td>
                        <td>{{ $author->email ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ $author->books_count }}</span></td>
                        <td><x-badge :type="$author->status" /></td>
                        <td class="text-end">
                            <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete author?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No authors registered.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $authors->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection