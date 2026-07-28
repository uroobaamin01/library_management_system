@extends('layouts.admin')

@section('title', 'My Profile')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
@endsection

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-md-6">
        <x-card title="Profile Information">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-input name="name" label="Full Name" :value="$user->name" :required="true" />
                <x-input name="email" label="Email Address" type="email" :value="$user->email" :required="true" />
                <x-input name="phone" label="Phone Number" :value="$user->phone" />
                <x-input name="profile_image" label="Profile Avatar" type="file" />

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Save Changes</button>
                </div>
            </form>
        </x-card>
    </div>

    <div class="col-md-6">
        <x-card title="Change Password">
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <x-input name="current_password" label="Current Password" type="password" :required="true" />
                <x-input name="password" label="New Password" type="password" :required="true" />
                <x-input name="password_confirmation" label="Confirm New Password" type="password" :required="true" />

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-key me-1"></i> Update Password</button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection