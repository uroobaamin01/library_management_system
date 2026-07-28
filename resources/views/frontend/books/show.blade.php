
@extends('frontend.layouts.app')

@section('title', $book->title . ' - Book Details')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm bg-white p-4">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=400&q=80' }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 400px; object-fit: cover;" alt="{{ $book->title }}">
            </div>
            <div class="col-md-8">
                <span class="badge bg-primary mb-2">{{ $book->category->name ?? 'General' }}</span>
                <h2 class="fw-bold mb-2">{{ $book->title }}</h2>
                <p class="text-muted fs-5 mb-3">By <span class="fw-semibold text-dark">{{ $book->author->name ?? 'Unknown' }}</span></p>

                <hr>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4">
                        <small class="text-muted d-block">ISBN</small>
                        <span class="fw-semibold">{{ $book->isbn ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <small class="text-muted d-block">Publisher</small>
                        <span class="fw-semibold">{{ $book->publisher->name ?? 'N/A' }}</span>
                    </div>
                    <div class="col-6 col-md-4">
                        <small class="text-muted d-block">Language</small>
                        <span class="fw-semibold">{{ $book->language->name ?? 'English' }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold">Description</h6>
                    <p class="text-muted small">{{ $book->description ?? 'No description provided for this book.' }}</p>
                </div>

                <div class="d-flex gap-2">
                    @auth
                        @if(Auth::user()->role === 'student')
                            <form action="{{ route('student.borrows.request', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-accent"><i class="fa-solid fa-hand-holding-hand me-1"></i> Request to Borrow</button>
                            </form>
                            <form action="{{ route('student.reservations.store', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary"><i class="fa-solid fa-bookmark me-1"></i> Reserve Copy</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-theme"><i class="fa-solid fa-right-to-bracket me-1"></i> Log in to Borrow / Reserve</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection