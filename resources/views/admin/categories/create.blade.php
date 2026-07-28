@extends('layouts.admin')

@section('title', 'Add Category')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-card title="Create New Category">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <x-input name="name" label="Category Name" placeholder="e.g. Computer Science" :required="true" />
                <x-textarea name="description" label="Description" placeholder="Optional category overview..." />
                <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" selected="active" :required="true" />

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Save Category</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection