@extends('layouts.admin')

@section('title', 'System Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <x-card title="General System Preferences">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <x-input name="system_title" label="System Title" :value="$settings['system_title'] ?? 'LMS Portal'" :required="true" />
                <x-input name="max_books_allowed" label="Max Books Issuable Per Student" type="number" :value="$settings['max_books_allowed'] ?? '3'" :required="true" />
                <x-input name="fine_rate_per_day" label="Overdue Fine Rate ($/Day)" type="number" step="0.5" :value="$settings['fine_rate_per_day'] ?? '1.00'" :required="true" />
                <x-input name="return_due_days" label="Default Issue Duration (Days)" type="number" :value="$settings['return_due_days'] ?? '14'" :required="true" />

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Save Configurations</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection