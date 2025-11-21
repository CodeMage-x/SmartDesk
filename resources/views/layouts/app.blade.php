@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDesk - IT Ticketing System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --cyan-primary:#0dcaf0; --cyan-dark:#17a2b8; --cyan-light:#9eeaf9; }
        .navbar-brand { color: var(--cyan-primary) !important; font-weight: bold; }
        .btn-cyan { background-color: var(--cyan-primary); border-color: var(--cyan-primary); color: #fff; }
        .btn-cyan:hover { background-color: var(--cyan-dark); border-color: var(--cyan-dark); color: #fff; }
        .btn-outline-cyan { color: var(--cyan-primary); border-color: var(--cyan-primary); }
        .btn-outline-cyan:hover { background-color: var(--cyan-primary); border-color: var(--cyan-primary); color: #fff; }
        .card-header-cyan { background-color: var(--cyan-primary); color:#fff; }
        .text-cyan { color: var(--cyan-primary) !important; }
        .border-cyan { border-color: var(--cyan-primary) !important; }
        .sidebar { background: linear-gradient(135deg, var(--cyan-dark), var(--cyan-primary)); min-height: calc(100vh - 56px); }
        .sidebar a { color:#fff; text-decoration:none; padding:10px 20px; display:block; border-radius:5px; margin:5px 10px; transition: all .3s; }
        .sidebar a:hover { background-color: rgba(255,255,255,.1); color:#fff; }
        .sidebar a.active { background-color: rgba(255,255,255,.2); }
        .stats-card { border-left: 4px solid var(--cyan-primary); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a
                class="navbar-brand"
                href="{{ Auth::check() ? route('dashboard') : (Route::has('home') ? route('home') : (Route::has('login') ? route('login') : url('/'))) }}"
            >
                <i class="fas fa-headset"></i> SmartDesk
            </a>

            @if(Auth::check())
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('password.change') }}">
                                <i class="fas fa-key me-2"></i> Change Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-right-from-bracket me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @if(Auth::check())
            <div class="col-md-3 col-lg-2 p-0">
                <div class="sidebar">
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.tickets') }}" class="@if(request()->routeIs('admin.tickets')) active @endif">
                            <i class="fas fa-tickets-alt me-2"></i> All Tickets
                        </a>
                        <a href="{{ route('admin.users') }}" class="@if(request()->routeIs('admin.users')) active @endif">
                            <i class="fas fa-users me-2"></i> Manage Users
                        </a>
                        <a href="{{ route('admin.create-user') }}" class="@if(request()->routeIs('admin.create-user')) active @endif">
                            <i class="fas fa-user-plus me-2"></i> Create User
                        </a>
                    @elseif(Auth::user()->isHelpdeskAgent())
                        <a href="{{ route('agent.dashboard') }}" class="@if(request()->routeIs('agent.dashboard')) active @endif">
                            <i class="fas fa-tachometer-alt me-2"></i> My Dashboard
                        </a>
                        <a href="{{ route('agent.tickets-pool') }}" class="@if(request()->routeIs('agent.tickets-pool')) active @endif">
                            <i class="fas fa-tasks me-2"></i> Available Tickets
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="@if(request()->routeIs('user.dashboard')) active @endif">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('user.create-ticket') }}" class="@if(request()->routeIs('user.create-ticket')) active @endif">
                            <i class="fas fa-plus me-2"></i> Create Ticket
                        </a>
                    @endif
                </div>
            </div>
            @endif

            <div class="@if(Auth::check()) col-md-9 col-lg-10 @else col-12 @endif">
                <main class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>