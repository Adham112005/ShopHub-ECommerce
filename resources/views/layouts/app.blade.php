<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ShopHub')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        .navbar .nav-link {
            transition: .2s;
        }

        .navbar .nav-link.active {
            color: #0d6efd !important;
            font-weight: 600;
        }

        .navbar .nav-link:hover {
            color: #0d6efd !important;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.35rem;
        }
    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

    <div class="container-fluid px-4">

        <a class="navbar-brand"
           href="{{ route('dashboard') }}">
            <i class="bi bi-shop-window me-2"></i>
            ShopHub
        </a>

        @auth

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>
                        Dashboard
                    </a>
                </li>

                @permission('View Roles')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                       href="{{ route('roles.index') }}">
                        <i class="bi bi-person-badge-fill me-2"></i>
                        Roles
                    </a>
                </li>
                @endpermission

                @permission('View Permissions')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}"
                       href="{{ route('permissions.index') }}">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        Permissions
                    </a>
                </li>
                @endpermission

                @permission('View Users')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="bi bi-people-fill me-1"></i>
                        Users
                    </a>
                </li>
                @endpermission

                @permission('View Categories')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                       href="{{ route('categories.index') }}">
                        <i class="bi bi-grid-fill me-1"></i>
                        Categories
                    </a>
                </li>
                @endpermission

                @permission('View Brands')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}"
                       href="{{ route('brands.index') }}">
                        <i class="bi bi-bookmark-fill me-1"></i>
                        Brands
                    </a>
                </li>
                @endpermission

                @permission('View Products')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">
                        <i class="bi bi-box-seam-fill me-1"></i>
                        Products
                    </a>
                </li>
                @endpermission

                @permission('View Orders')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                    href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt-cutoff me-1"></i>
                        Orders
                    </a>
                </li>
                @endpermission

            </ul>

            <div class="d-flex align-items-center">

                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>

                <form action="{{ route('logout') }}"
                      method="POST">

                    @csrf

                    <button class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>

                </form>

            </div>

        </div>

        @endauth

    </div>

</nav>

<div class="container-fluid px-4 mt-4">

    @yield('content')

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>