@extends('layouts.admin')

@section('title', 'Notifications')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
@endsection

@section('content')
<x-card title="System Notifications">
    <x-slot name="headerActions">
        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-check-double me-1"></i> Mark All as Read</button>
        </form>
    </x-slot>

    <ul class="list-group list-group-flush">
        @forelse($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center py-3 {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                <div>
                    <h6 class="mb-1 fw-bold">{{ $notification->title }}</h6>
                    <p class="mb-0 text-muted small">{{ $notification->message }}</p>
                </div>
                <span class="text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
        @empty
            <li class="text-center text-muted py-4">No notifications present.</li>
        @endforelse
    </ul>

    <div class="mt-3">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection