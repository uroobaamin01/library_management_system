<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Library Portal')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #0d9488;
            --accent-color: #f59e0b;
            --bg-light: #f8fafc;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-light); color: #334155; }
        
        /* Glassmorphism Navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
        .navbar-brand { font-weight: 700; color: var(--primary-color) !important; font-size: 1.4rem; }
        .nav-link { font-weight: 500; color: #475569 !important; transition: all 0.3s ease; }
        .nav-link:hover, .nav-link.active { color: var(--secondary-color) !important; }

        /* Custom Cards & Buttons */
        .card-custom { border: none; border-radius: 12px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
        .btn-theme { background-color: var(--primary-color); color: #fff; border-radius: 8px; padding: 10px 24px; font-weight: 600; border: none; }
        .btn-theme:hover { background-color: #0f2942; color: #fff; }
        .btn-accent { background-color: var(--secondary-color); color: #fff; border-radius: 8px; padding: 10px 24px; font-weight: 600; border: none; }
        .btn-accent:hover { background-color: #0f766e; color: #fff; }
        
        /* Footer */
        .footer-main { background-color: #0f172a; color: #94a3b8; padding-top: 60px; padding-bottom: 30px; }
        .footer-main h5 { color: #f8fafc; font-weight: 600; margin-bottom: 20px; }
        .footer-main a { color: #94a3b8; text-decoration: none; transition: color 0.2s; }
        .footer-main a:hover { color: #5eead4; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top glass-nav py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fa-solid fa-book-open-reader me-2 text-success"></i> UniLibrary
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-links navbar-nav ms-auto me-4 mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Books Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#facilities">Facilities</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact Us</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <!-- User Logged In Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user fs-5"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userMenu">
                                @if(Auth::user()->role === 'student')
                                    <li><a class="dropdown-item py-2" href="{{ route('student.dashboard') }}"><i class="fa-solid fa-gauge me-2 text-primary"></i> Student Dashboard</a></li>
                                @elseif(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-gear me-2 text-primary"></i> Admin Panel</a></li>
                                @elseif(Auth::user()->role === 'librarian')
                                    <li><a class="dropdown-item py-2" href="{{ route('librarian.dashboard') }}"><i class="fa-solid fa-book-user me-2 text-primary"></i> Librarian Portal</a></li>
                                @endif
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Guest State Links -->
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-theme btn-sm px-3">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div style="margin-top: 80px;">
        @yield('content')
    </div>

    <!-- Footer Section -->
    <footer class="footer-main">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-3"><i class="fa-solid fa-book-open-reader text-success me-2"></i>UniLibrary</h5>
                    <p class="small">Providing digital access and physical literature resources for research, study, and academic development across modern university faculties.</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('books.index') }}">Browse Catalog</a></li>
                        <li><a href="{{ route('contact.index') }}">Contact Support</a></li>
                        <li><a href="{{ route('login') }}">Member Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Library Hours</h5>
                    <p class="small mb-1"><i class="fa-regular fa-clock me-2 text-warning"></i> Mon - Fri: 8:00 AM - 9:00 PM</p>
                    <p class="small mb-1"><i class="fa-regular fa-clock me-2 text-warning"></i> Saturday: 9:00 AM - 5:00 PM</p>
                    <p class="small"><i class="fa-regular fa-clock me-2 text-danger"></i> Sunday: Closed</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Newsletter</h5>
                    <p class="small">Subscribe to get updates on new arrivals & library announcements.</p>
                    <form action="#" method="POST" class="d-flex gap-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-accent btn-sm">Join</button>
                    </form>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small">
                <p class="mb-0">&copy; {{ date('Y') }} University Library Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
    @stack('scripts')
</body>
</html>