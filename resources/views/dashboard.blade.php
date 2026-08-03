@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<h2 class="mb-4">
    Dashboard
</h2>

<div class="row g-4">

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <i class="bi bi-people-fill fs-1 text-primary"></i>

                <h5 class="mt-3">
                    Customers
                </h5>

                <h2>
                    {{ $totalUsers }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <i class="bi bi-box-seam fs-1 text-success"></i>

                <h5 class="mt-3">
                    Products
                </h5>

                <h2>
                    {{ $totalProducts }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <i class="bi bi-bag-check-fill fs-1 text-warning"></i>

                <h5 class="mt-3">
                    Orders
                </h5>

                <h2>
                    {{ $totalOrders }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <i class="bi bi-tags-fill fs-1 text-info"></i>

                <h5 class="mt-3">
                    Categories
                </h5>

                <h2>
                    {{ $totalCategories }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body text-center">
                <i class="bi bi-award-fill fs-1 text-secondary"></i>

                <h5 class="mt-3">
                    Brands
                </h5>

                <h2>
                    {{ $totalBrands }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0 bg-success text-white">
            <div class="card-body text-center">
                <i class="bi bi-currency-dollar fs-1"></i>

                <h5 class="mt-3">
                    Revenue
                </h5>

                <h2>
                    ${{ number_format($totalRevenue,2) }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        <h5 class="mb-0">
            Latest Orders
        </h5>

    </div>

    <div class="card-body">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Customer</th>

                    <th>Total</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

                @forelse($latestOrders as $order)

                <tr>

                    <td>#{{ $order->id }}</td>

                    <td>{{ $order->user->name }}</td>

                    <td>${{ number_format($order->total_price,2) }}</td>

                    <td>

    @switch($order->status)

        @case('Pending')
            <span class="badge bg-warning text-dark">
                Pending
            </span>
            @break

        @case('Processing')
            <span class="badge bg-info">
                Processing
            </span>
            @break

        @case('Shipped')
            <span class="badge bg-primary">
                Shipped
            </span>
            @break

        @case('Delivered')
            <span class="badge bg-success">
                Delivered
            </span>
            @break

        @case('Cancelled')
            <span class="badge bg-danger">
                Cancelled
            </span>
            @break

        @default
            <span class="badge bg-secondary">
                {{ $order->status }}
            </span>

    @endswitch

</td>

                    <td>

                        {{ $order->created_at->format('d M Y') }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        No Orders Yet

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header bg-warning text-dark">

        <h5 class="mb-0">

            <i class="bi bi-exclamation-triangle-fill"></i>

            Low Stock Products

        </h5>

    </div>

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Image</th>

                    <th>Product</th>

                    <th>Category</th>

                    <th>Brand</th>

                    <th>Stock</th>

                </tr>

            </thead>

            <tbody>

                @forelse($lowStockProducts as $product)

                    <tr>

                        <td width="80">

                            @if($product->image)

                                <img src="{{ asset('storage/'.$product->image) }}"
                                     width="60"
                                     height="60"
                                     class="rounded"
                                     style="object-fit:cover;">

                            @endif

                        </td>

                        <td>

                            {{ $product->name }}

                        </td>

                        <td>

                            {{ $product->category->name }}

                        </td>

                        <td>

                            {{ $product->brand->name }}

                        </td>

                        <td>

                            @if($product->quantity <= 2)

                                <span class="badge bg-danger">

                                    {{ $product->quantity }}

                                </span>

                            @else

                                <span class="badge bg-warning text-dark">

                                    {{ $product->quantity }}

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center text-success">

                            🎉 No low stock products.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header bg-danger text-white">

        <h5 class="mb-0">

            <i class="bi bi-x-circle-fill"></i>

            Out of Stock Products

        </h5>

    </div>

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Image</th>

                    <th>Product</th>

                    <th>Category</th>

                    <th>Brand</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($outOfStockProducts as $product)

                    <tr>

                        <td width="80">

                            @if($product->image)

                                <img src="{{ asset('storage/'.$product->image) }}"
                                     width="60"
                                     height="60"
                                     class="rounded"
                                     style="object-fit:cover;">

                            @endif

                        </td>

                        <td>{{ $product->name }}</td>

                        <td>{{ $product->category->name }}</td>

                        <td>{{ $product->brand->name }}</td>

                        <td>

                            <span class="badge bg-danger">

                                Out of Stock

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center text-success">

                            🎉 No out of stock products.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
@endsection