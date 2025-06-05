<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS (opsional) --}}
    <style>
        body {
            padding-top: 56px;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 1rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users') }}">Manajemen Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.settings') }}">Pengaturan</a>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Main Content --}}
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                <hr>
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
