<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | ShopHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height:100vh;">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <i class="bi bi-bag-fill text-primary"
                           style="font-size:60px;"></i>

                        <h2 class="mt-3">

                            ShopHub Login

                        </h2>

                        <p class="text-muted">

                            Sign in to your account

                        </p>

                    </div>

                    @if($errors->any())

                        <div class="alert alert-danger">

                            {{ $errors->first() }}

                        </div>

                    @endif

                    <form action="{{ route('login.store') }}"
                          method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="form-check mb-4">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="form-check-input"
                                id="remember">

                            <label class="form-check-label"
                                   for="remember">

                                Remember Me

                            </label>

                        </div>

                        <button
                            class="btn btn-primary w-100">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Login

                        </button>

                    </form>

                    <br>

                    <p>

                        Don't have an account?

                        <a href="{{ route('register') }}">

                            Register

                        </a>

                    </p>

                    <div class="text-center mt-4">

                        <a href="{{ route('store.home') }}"
                           class="text-decoration-none">

                            ← Back to Store

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>