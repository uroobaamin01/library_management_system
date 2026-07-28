@extends('layouts.admin')

@section('title', 'Add Author')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.authors.index') }}">Authors</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-card title="Add New Author">
            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf
                <x-input name="name" label="Author Full Name" placeholder="e.g. Robert C. Martin" :required="true" />
                <x-input name="email" label="Email Address" type="email" placeholder="author@example.com" />
                <x-textarea name="biography" label="Short Biography" placeholder="Brief author background..." />
                <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" selected="active" :required="true" />

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.authors.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Save Author</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection