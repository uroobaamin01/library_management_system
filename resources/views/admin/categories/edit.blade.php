@extends('layouts.admin')

@section('title', 'Edit Category')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-card title="Edit Category: {{ $category->name }}">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <x-input name="name" label="Category Name" :value="$category->name" :required="true" />
                <x-textarea name="description" label="Description" :value="$category->description" />
                <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="$category->status" :required="true" />

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate me-1"></i> Update Category</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection