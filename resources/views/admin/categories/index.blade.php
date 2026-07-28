@extends('layouts.admin')

@section('title', 'Categories')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection

@section('content')
<x-card title="Category Management">
    <x-slot name="headerActions">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm fw-semibold">
            <i class="fa-solid fa-plus me-1"></i> Add Category
        </a>
    </x-slot>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Total Books</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td><span class="badge bg-info text-dark">{{ $category->books_count }}</span></td>
                        <td><x-badge :type="$category->status" /></td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No categories available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection