@extends('layouts.admin')

@section('title', 'Languages')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Languages</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <x-card title="Add Language">
            <form action="{{ route('admin.languages.store') }}" method="POST">
                @csrf
                <x-input name="name" label="Language Name" placeholder="e.g. English" :required="true" />
                <x-input name="code" label="ISO Code" placeholder="e.g. en" :required="true" />
                <button type="submit" class="btn btn-primary w-100 mt-2"><i class="fa-solid fa-plus me-1"></i> Add Language</button>
            </form>
        </x-card>
    </div>
    <div class="col-md-8">
        <x-card title="Registered Languages">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Language</th>
                            <th>ISO Code</th>
                            <th>Associated Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($languages as $language)
                            <tr>
                                <td class="fw-semibold">{{ $language->name }}</td>
                                <td><code>{{ $language->code }}</code></td>
                                <td><span class="badge bg-secondary">{{ $language->books_count }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No languages registered.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection