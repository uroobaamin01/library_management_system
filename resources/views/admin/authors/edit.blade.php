@extends('layouts.admin')

@section('title', 'Edit Author')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.authors.index') }}">Authors</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-card title="Edit Author: {{ $author->name }}">
            <form action="{{ route('admin.authors.update', $author) }}" method="POST">
                @csrf
                @method('PUT')
                <x-input name="name" label="Author Full Name" :value="$author->name" :required="true" />
                <x-input name="email" label="Email Address" type="email" :value="$author->email" />
                <x-textarea name="biography" label="Short Biography" :value="$author->biography" />
                <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="$author->status" :required="true" />

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.authors.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrows-rotate me-1"></i> Update Author</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection