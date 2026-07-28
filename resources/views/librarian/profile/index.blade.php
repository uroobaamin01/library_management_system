@extends('librarian.layouts.app')

@section('title', 'Librarian Profile')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-id-card text-primary me-2"></i>My Profile</h4>
            <p class="text-muted small mb-0">Manage your personal information and account security.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Please fix the errors below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Profile Card Overview -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <div class="mb-3 position-relative d-inline-block mx-auto">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                        {{ strtoupper(substr($user->name ?? 'L', 0, 1)) }}
                    </div>
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <span class="badge bg-primary-subtle text-primary mb-3 align-self-center px-3 py-2 rounded-pill">
                    <i class="fa-solid fa-user-shield me-1"></i>Librarian
                </span>
                <p class="text-muted small mb-0"><i class="fa-regular fa-envelope me-1"></i>{{ $user->email }}</p>
                <p class="text-muted small mb-0 mt-1"><i class="fa-regular fa-calendar-check me-1"></i>Joined: {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</p>
            </div>
        </div>

        <!-- Edit Profile & Password Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-user-gear me-2 text-primary"></i>Account Settings</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('librarian.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="text-primary fw-bold small text-uppercase mb-3">Personal Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone ?? '') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <h6 class="text-primary fw-bold small text-uppercase mb-3">Change Password <span class="text-muted fw-normal">(Leave blank to keep current)</span></h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="current_password" class="form-label fw-semibold small">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="password" class="form-label fw-semibold small">New Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="password_confirmation" class="form-label fw-semibold small">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary fw-semibold px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection