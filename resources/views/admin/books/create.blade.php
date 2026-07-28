@extends('layouts.admin')

@section('title', 'Add New Book')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
<x-card title="Add New Book Entry">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <x-input name="title" label="Book Title" placeholder="Full title" :required="true" />
            </div>
            <div class="col-md-4">
                <x-input name="isbn" label="ISBN Code" placeholder="e.g. 978-3-16-148410-0" :required="true" />
            </div>

            <div class="col-md-3">
                <x-select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="author_id" label="Author" :options="$authors->pluck('name', 'id')" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="publisher_id" label="Publisher" :options="$publishers->pluck('name', 'id')" :required="true" />
            </div>
            <div class="col-md-3">
                <x-select name="language_id" label="Language" :options="$languages->pluck('name', 'id')" :required="true" />
            </div>

            <div class="col-md-3">
                <x-input name="edition" label="Edition Number" type="number" value="1" :required="true" />
            </div>
            <div class="col-md-3">
                <x-input name="publish_year" label="Publish Year" type="number" value="{{ date('Y') }}" />
            </div>
            <div class="col-md-3">
                <x-input name="price" label="Purchase Price ($)" type="number" step="0.01" value="0.00" :required="true" />
            </div>
            <div class="col-md-3">
                <x-input name="copies_count" label="Copies to Generate" type="number" value="1" :required="true" />
            </div>

            <div class="col-12">
                <x-textarea name="summary" label="Summary / Synopsis" rows="3" />
            </div>

            <div class="col-md-6">
                <x-input name="cover_image" label="Cover Image" type="file" />
            </div>
            <div class="col-md-6">
                <x-input name="additional_images[]" label="Secondary Images (Multiple)" type="file" multiple />
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.books.index') }}" class="btn btn-light border">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Save Book & Generate Copies</button>
        </div>
    </form>
</x-card>
@endsection