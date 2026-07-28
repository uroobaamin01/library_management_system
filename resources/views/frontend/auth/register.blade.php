@extends('frontend.layouts.app')

@section('title', 'Student Registration - UniLibrary')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-custom border bg-white p-4 p-md-5">
                <h4 class="fw-bold text-center mb-1 text-primary">Student Registration</h4>
                <p class="text-muted text-center small mb-4">Create your account to access library catalog & books</p>

                @if($errors->any())
                    <div class="alert alert-danger py-2 small mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Ali Ahmed" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="student@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary fw-semibold py-2">Create Account</button>
                    </div>

                    <div class="text-center small text-muted">
                        Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Log In here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection