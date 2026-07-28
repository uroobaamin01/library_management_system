<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - LMS Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom Admin Stylesheet -->
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --primary-bg: #f8f9fa;
            --dark-sidebar: #1e293b;
            --sidebar-hover: #334155;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--dark-sidebar);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: margin 0.25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.2rem 1.5rem;
            font-size: 1.25rem;
            font-weight: bold;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper .nav-link {
            padding: 0.75rem 1.5rem;
            color: #94a3b8;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        #sidebar-wrapper .nav-link:hover, 
        #sidebar-wrapper .nav-link.active {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        #sidebar-wrapper .nav-link.active {
            border-left: 4px solid #3b82f6;
        }

        /* Main Content Wrapper */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin 0.25s ease-out, width 0.25s ease-out;
        }

        /* Top Navbar */
        .admin-navbar {
            height: var(--topbar-height);
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Footer */
        .admin-footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        /* Sidebar Toggle Behavior */
        body.sb-toggled #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        body.sb-toggled #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            body.sb-toggled #sidebar-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar Partial -->
        @include('admin.partials.sidebar')

        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper">
            <!-- Top Navbar Partial -->
            @include('admin.partials.navbar')

            <!-- Main Page View -->
            <main class="container-fluid p-4">
                <!-- Breadcrumb Partial -->
                @include('admin.partials.breadcrumb')

                <!-- Alert Messages Partial -->
                @include('admin.partials.alerts')

                <!-- Main Section Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="admin-footer text-center">
                <div class="container-fluid">
                    <span>&copy; {{ date('Y') }} LMS Admin Panel. All Rights Reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery & Bootstrap 5 JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Layout Scripts -->
    <script>
        $(document).ready(function () {
            // Sidebar Toggle
            $("#sidebarToggle").on("click", function (e) {
                e.preventDefault();
                $("body").toggleClass("sb-toggled");
            });
        });
    </script>
    @stack('scripts')
</body>
</html>