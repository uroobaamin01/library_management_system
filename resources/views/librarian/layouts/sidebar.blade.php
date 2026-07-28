<nav id="sidebar">
    <div class="sidebar-header d-flex align-items-center gap-2">
        <i class="fa-solid fa-book-bookmark text-info"></i>
        <span>Library Panel</span>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ request()->routeIs('librarian.dashboard') ? 'active' : '' }}">
            <a href="{{ route('librarian.dashboard') }}">
                <i class="fa-solid fa-chart-line me-2"></i>Dashboard
            </a>
        </li>

        <li class="nav-item text-uppercase text-secondary px-3 mt-3 mb-1 small fw-bold" style="font-size: 0.75rem;">Circulation</li>

        <li class="{{ request()->routeIs('librarian.issue.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.issue.index') }}">
                <i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Issue Book
            </a>
        </li>

        <li class="{{ request()->routeIs('librarian.return.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.return.index') }}">
                <i class="fa-solid fa-arrow-down-to-bracket me-2"></i>Return Book
            </a>
        </li>

        <li class="{{ request()->routeIs('librarian.renew.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.renew.index') }}">
                <i class="fa-solid fa-rotate me-2"></i>Renew Book
            </a>
        </li>

        <li class="nav-item text-uppercase text-secondary px-3 mt-3 mb-1 small fw-bold" style="font-size: 0.75rem;">Requests & Holds</li>

        <li class="{{ request()->routeIs('librarian.requests.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.requests.index') }}">
                <i class="fa-solid fa-inbox me-2"></i>Book Requests
            </a>
        </li>

        <li class="{{ request()->routeIs('librarian.reservations.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.reservations.index') }}">
                <i class="fa-solid fa-clock-rotate-left me-2"></i>Reservations
            </a>
        </li>

        <li class="nav-item text-uppercase text-secondary px-3 mt-3 mb-1 small fw-bold" style="font-size: 0.75rem;">Members & Accounting</li>

        <li class="{{ request()->routeIs('librarian.students.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.students.index') }}">
                <i class="fa-solid fa-user-graduate me-2"></i>Students Management
            </a>
        </li>

        <li class="{{ request()->routeIs('librarian.fines.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.fines.index') }}">
                <i class="fa-solid fa-receipt me-2"></i>Fine Management
            </a>
        </li>

        <li class="{{ request()->routeIs('librarian.reports.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.reports.index') }}">
                <i class="fa-solid fa-file-invoice me-2"></i>Reports
            </a>
        </li>

        <li class="nav-item text-uppercase text-secondary px-3 mt-3 mb-1 small fw-bold" style="font-size: 0.75rem;">Account</li>

        <li class="{{ request()->routeIs('librarian.profile.*') ? 'active' : '' }}">
            <a href="{{ route('librarian.profile.show') }}">
                <i class="fa-solid fa-user-gear me-2"></i>Profile
            </a>
        </li>

        <li>
            <form action="{{ route('logout') }}" method="POST" id="sidebar-logout-form" class="d-none">@csrf</form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="text-danger">
                <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
            </a>
        </li>
    </ul>
</nav>