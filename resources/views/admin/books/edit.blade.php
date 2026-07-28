@extends('layouts.admin')

@section('title', 'Edit Book')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<x-card title="Edit Book: {{ $book->title }}">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <x-input name="title" label="Book Title" :value="$book->title" :required="true" />
            </div>
            <div class="col-md-4">
                <x-input name="isbn" label="ISBN Code" :value="$book->isbn" :required="true" />
            </div>

            <div class="col-md-3">
                <x-select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :selected="$book->category_id" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="author_id" label="Author" :options="$authors->pluck('name', 'id')" :selected="$book->author_id" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="publisher_id" label="Publisher" :options="$publishers->pluck('name', 'id')" :selected="$book->publisher_id" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="language_id" label="Language" :options="$languages->pluck('name', 'id')" :selected="$book->language_id" :required="true" />
            </div>

            <div class="col-md-3">
                <x-input name="edition" label="Edition" type="number" :value="$book->edition" :required="true" />
            </div>
            <div class="col-md-3">
                <x-input name="publish_year" label="Publish Year" type="number" :value="$book->publish_year" />
            </div>
            <div class="col-md-3">
                <x-input name="price" label="Price ($)" type="number" step="0.01" :value="$book->price" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="status" label="Status" :options="['available' => 'Available', 'archived' => 'Archived', 'out_of_stock' => 'Out of Stock']" :selected="$book->status" :required="true" />
            </div>

            <div class="col-12">
                <x-textarea name="summary" label="Summary" :value="$book->summary" rows="3" />
            </div>

            <div class="col-md-12">
                <x-input name="cover_image" label="Replace Cover Image" type="file" />
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.books.index') }}" class="btn btn-light border">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate me-1"></i> Update Book</button>
        </div>
    </form>
</x-card>
@endsection