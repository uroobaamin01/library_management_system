<div id="sidebar-wrapper">
    <div class="sidebar-heading text-center">
        <i class="fa-solid fa-book-bookmark me-2"></i> LMS Admin
    </div>
    <div class="list-group list-group-flush mt-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fa-solid fa-list-check"></i> Categories
        </a>

        <!-- Authors -->
        <a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen"></i> Authors
        </a>

        <!-- Publishers -->
        <a href="{{ route('admin.publishers.index') }}" class="nav-link {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i> Publishers
        </a>

        <!-- Languages -->
        <a href="{{ route('admin.languages.index') }}" class="nav-link {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
            <i class="fa-solid fa-language"></i> Languages
        </a>

        <!-- Books -->
        <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book"></i> Books Catalog
        </a>

        <!-- Physical Locations Header -->
        <div class="text-uppercase small fw-bold text-secondary px-3 mt-3 mb-1">Locations</div>

        <!-- Racks -->
        <a href="{{ route('admin.racks.index') }}" class="nav-link {{ request()->routeIs('admin.racks.*') ? 'active' : '' }}">
            <i class="fa-solid fa-cubes"></i> Racks
        </a>

        <!-- Shelves -->
        <a href="{{ route('admin.shelves.index') }}" class="nav-link {{ request()->routeIs('admin.shelves.*') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Shelves
        </a>

        <!-- System Section Header -->
        <div class="text-uppercase small fw-bold text-secondary px-3 mt-3 mb-1">System</div>

        <!-- Settings -->
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fa-solid fa-sliders"></i> Settings
        </a>

        <!-- Activity Audit Logs -->
        <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-shield-halved"></i> Audit Logs
        </a>
    </div>
</div>