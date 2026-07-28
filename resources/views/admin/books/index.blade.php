@extends('layouts.admin')

@section('title', 'Books Catalog')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Books</li>
@endsection

@section('content')
<x-card title="Master Book Catalog">
    <x-slot name="headerActions">
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm fw-semibold">
            <i class="fa-solid fa-plus me-1"></i> Add New Book
        </a>
    </x-slot>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Cover</th>
                    <th>Title / ISBN</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Copies</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="rounded" width="40" height="55" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 40px; height: 55px;">
                                    <i class="fa-solid fa-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $book->title }}</div>
                            <div class="text-muted small">ISBN: {{ $book->isbn }}</div>
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $book->category->name }}</span></td>
                        <td>{{ $book->author->name }}</td>
                        <td>${{ number_format($book->price, 2) }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $book->copies_count }}</span></td>
                        <td><x-badge :type="$book->status" /></td>
                        <td class="text-end">
                            <a href="{{ route('admin.books.show', $book) }}" class="btn btn-sm btn-outline-info me-1" title="View Details">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit Book">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-box-archive"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">No books found in catalog.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection