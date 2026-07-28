<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background-color: #0f172a; color: #94a3b8; }
        .sidebar .nav-link { color: #94a3b8; padding: 12px 20px; font-weight: 500; border-radius: 8px; margin-bottom: 4px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #38bdf8; }
        .content-area { padding: 30px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none mb-4 ps-2">
                <i class="fa-solid fa-book-open-reader fa-xl text-info me-2"></i>
                <span class="fs-5 fw-bold">Student Portal</span>
            </a>
            <hr class="border-secondary mb-3">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('student.borrows.index') }}" class="nav-link {{ request()->routeIs('student.borrows.*') ? 'active' : '' }}"><i class="fa-solid fa-book-bookmark me-2"></i> Borrowed Books</a></li>
                <li class="nav-item"><a href="{{ route('student.reservations.index') }}" class="nav-link {{ request()->routeIs('student.reservations.*') ? 'active' : '' }}"><i class="fa-solid fa-clock me-2"></i> Reservations</a></li>
                <li class="nav-item"><a href="{{ route('student.fines.index') }}" class="nav-link {{ request()->routeIs('student.fines.*') ? 'active' : '' }}"><i class="fa-solid fa-receipt me-2"></i> Fines</a></li>
                <li class="nav-item"><a href="{{ route('student.profile.index') }}" class="nav-link {{ request()->routeIs('student.profile.*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear me-2"></i> Profile</a></li>
            </ul>
            <hr class="border-secondary mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i> Log Out</button>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9 col-lg-10 content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>