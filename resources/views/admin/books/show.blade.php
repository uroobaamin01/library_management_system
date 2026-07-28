@extends('layouts.admin')

@section('title', 'Book Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
    <li class="breadcrumb-item active" aria-current="page">Details</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <x-card>
            <div class="text-center mb-3">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="img-fluid rounded shadow-sm" style="max-height: 280px;" alt="Cover">
                @else
                    <div class="bg-light rounded p-5 text-muted border">
                        <i class="fa-solid fa-book fa-4x"></i>
                    </div>
                @endif
            </div>
            <h5 class="fw-bold text-center mb-1">{{ $book->title }}</h5>
            <p class="text-muted text-center small mb-3">ISBN: {{ $book->isbn }}</p>

            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between"><span>Category:</span> <strong>{{ $book->category->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Author:</span> <strong>{{ $book->author->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Publisher:</span> <strong>{{ $book->publisher->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Language:</span> <strong>{{ $book->language->name }}</strong></li>
                <li class="list-group-item d-flex justify-content-between"><span>Price:</span> <strong>${{ number_format($book->price, 2) }}</strong></li>
            </ul>
        </x-card>
    </div>

    <div class="col-md-8">
        <x-card title="Physical Book Copies">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Barcode</th>
                            <th>Copy Number</th>
                            <th>Status</th>
                            <th>Condition</th>
                            <th class="text-end">Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($book->copies as $copy)
                            <tr>
                                <td><code>{{ $copy->barcode }}</code></td>
                                <td>{{ $copy->copy_number }}</td>
                                <td><x-badge :type="$copy->status" /></td>
                                <td class="text-capitalize">{{ $copy->condition }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.book-copies.update-status', $copy) }}" method="POST" class="d-flex justify-content-end gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" style="width: 110px;">
                                            <option value="available" {{ $copy->status == 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="issued" {{ $copy->status == 'issued' ? 'selected' : '' }}>Issued</option>
                                            <option value="lost" {{ $copy->status == 'lost' ? 'selected' : '' }}>Lost</option>
                                            <option value="damaged" {{ $copy->status == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                        </select>
                                        <input type="hidden" name="condition" value="{{ $copy->condition }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No physical copies created for this book.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection