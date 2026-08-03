<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        @yield('title', 'ShopHub')

    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        .pagination .page-link{

            border:none;
            margin:0 5px;
            width:42px;
            height:42px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#333;
            background:#c9cacc;
            transition:.3s;

        }

        .pagination .page-link:hover{

            background:#0d6efd;
            color:white;

        }

        .pagination .active .page-link{

            background:#0d6efd;
            color:white;
            border:none;

        }

    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand"
           href="{{ route('store.home') }}">

            ShopHub

        </a>

        <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">

                    <a class="nav-link"
                       href="{{ route('store.home') }}">

                        Home

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="{{ route('store.products') }}">

                        Products

                    </a>

                </li>

            </ul>

            <ul class="navbar-nav">

                @auth

                    @if(auth()->user()->role->name !== 'Customer')

                        <li class="nav-item">

                            <a class="nav-link"
                               href="{{ route('dashboard') }}">

                                <i class="bi bi-speedometer2"></i>

                                Dashboard

                            </a>

                        </li>

                    @else

                        <li class="nav-item">

                            <a class="nav-link"
                               href="{{ route('orders.index') }}">

                                <i class="bi bi-bag"></i>

                                Orders

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link"
                               href="{{ route('cart.index') }}">

                                <i class="bi bi-cart"></i>

                                Cart

                                @if(auth()->user()->carts()->count())

                                    <span class="badge bg-danger">

                                        {{ auth()->user()->carts()->count() }}

                                    </span>

                                @endif

                            </a>

                        </li>

                    @endif

                    <li class="nav-item">

                        <form action="{{ route('logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="btn btn-link nav-link">

                                Logout

                            </button>

                        </form>

                    </li>

                @else

                    <li class="nav-item">

                        <a class=" btn btn-outline-light btn-sm" style="background-color: #6d6d6d"
                           href="{{ route('login') }}">

                            <i class="bi bi-person-lock"></i>

                            Login

                        </a>

                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>

<div class="container py-4">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>