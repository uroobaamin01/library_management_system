<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>
        @yield('breadcrumbs')
    </ol>
</nav>