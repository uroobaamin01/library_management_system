<nav class="navbar navbar-expand-lg navbar-light admin-navbar px-4">
    <div class="container-fluid p-0">
        <!-- Toggle Button -->
        <button class="btn btn-sm btn-outline-secondary" id="sidebarToggle" type="button">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Navbar Right Items -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <a class="text-secondary position-relative text-decoration-none me-2" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New notifications</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notificationDropdown" style="width: 280px;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                        <strong>Notifications</strong>
                        <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none small">View All</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="px-3 py-2 text-muted small">No new unread notifications.</li>
                </ul>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a class="d-flex align-items-center gap-2 text-dark text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                    <span class="fw-semibold small">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.edit') }}">
                            <i class="fa-regular fa-user text-muted"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.settings.index') }}">
                            <i class="fa-solid fa-gear text-muted"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>