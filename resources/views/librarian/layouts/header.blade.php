<nav class="navbar navbar-expand-lg navbar-custom px-4 py-2 border-bottom">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-light me-3">
            <i class="fa-solid fa-bars"></i>
        </button>

        <span class="navbar-brand fw-semibold text-secondary">
            Librarian Operations Portal
        </span>

        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light position-relative rounded-circle p-2" data-bs-toggle="dropdown">
                    <i class="fa-regular fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="width: 280px;">
                    <li><h6 class="dropdown-header">Notifications</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item small text-wrap text-muted" href="#">No new system unread alerts.</a></li>
                </ul>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="fw-medium small">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                        <a class="dropdown-item" href="{{ route('librarian.profile.show') }}">
                            <i class="fa-regular fa-id-card me-2"></i>My Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>