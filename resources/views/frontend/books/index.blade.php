@extends('frontend.layouts.app')

@section('title', 'Books Catalog - Library Portal')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card card-custom p-3 bg-white border">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-filter text-primary me-2"></i>Filter Books</h5>
                <form action="{{ route('books.index') }}" method="GET">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Search Title / ISBN</label>
                        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Category</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Author</label>
                        <select name="author" class="form-select form-select-sm">
                            <option value="">All Authors</option>
                            @foreach($authors as $aut)
                                <option value="{{ $aut->id }}" {{ request('author') == $aut->id ? 'selected' : '' }}>
                                    {{ $aut->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> Apply Filters</button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Available Books Catalog</h4>
                <span class="text-muted small">Showing {{ $books->count() }} results</span>
            </div>

            <div class="row g-4">
                @forelse($books as $book)
                    <div class="col-md-4 col-sm-6">
                        <div class="card card-custom h-100 bg-white border">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=400&q=80' }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $book->title }}">
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-info-subtle text-info border mb-2 w-auto me-auto small">{{ $book->category->name ?? 'General' }}</span>
                                <h6 class="fw-bold mb-1">{{ Str::limit($book->title, 40) }}</h6>
                                <p class="text-muted small mb-3">By {{ $book->author->name ?? 'Unknown Author' }}</p>
                                <div class="mt-auto">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary w-100"><i class="fa-solid fa-eye me-1"></i> View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center">
                        <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No books match your filter criteria.</h5>
                        <a href="{{ route('books.index') }}" class="btn btn-accent btn-sm mt-2">Clear All Filters</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection