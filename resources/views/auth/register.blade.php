<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register | ShopHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height:100vh;">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow-lg border-0">

                <div class="card-body p-3">

                    <div class="text-center mb-4">

                        <i class="bi bi-person-plus-fill text-primary"
                           style="font-size:60px;"></i>

                        <h2 class="mt-3">

                            Create Account

                        </h2>

                        <p class="text-muted">

                            Join ShopHub and start shopping

                        </p>

                    </div>

                    @if($errors->any())

                        <div class="alert alert-danger">

                            {{ $errors->first() }}

                        </div>

                    @endif

                    <form method="POST"
                          action="{{ route('register.store') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                    <label class="form-label">
                        Phone Number
                    </label>

                    <div class="input-group">

                        <select
                            name="phone_country"
                            class="form-select"
                            style="max-width:130px;">

                            <option value="EG" selected>🇪🇬 +20</option>
                            <option value="SA">🇸🇦 +966</option>
                            <option value="AE">🇦🇪 +971</option>
                            <option value="KW">🇰🇼 +965</option>
                            <option value="QA">🇶🇦 +974</option>
                            <option value="BH">🇧🇭 +973</option>
                            <option value="OM">🇴🇲 +968</option>
                            <option value="JO">🇯🇴 +962</option>
                            <option value="LB">🇱🇧 +961</option>

                        </select>

                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-control"
                            placeholder="000 000 0000">

                    </div>

                </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="user@example.com"
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

                        <div class="mb-4">

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 ">

                            <i class="bi bi-person-check-fill"></i>

                            Register

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <p class="mb-2">

                            Already have an account?

                            <a href="{{ route('login') }}">

                                Login

                            </a>

                        </p>

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