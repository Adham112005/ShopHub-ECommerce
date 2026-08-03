@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Products</h2>

        @permission('Add Product')

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#productModal">

            + Add Product

        </button>

        @endpermission

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Category</th>

                    <th>Brand</th>

                    <th>SKU</th>

                    <th>Price</th>

                    <th>Qty</th>

                    <th>Max / Order</th>

                    <th>Status</th>

                    @if(auth()->user()->hasPermission('Edit Product') || auth()->user()->hasPermission('Delete Product'))

                        <th width="180">

                            Actions

                        </th>

                    @endif

                </tr>

            </thead>

            <tbody>

            @forelse($products as $product)

                <tr>

                    <td>{{ $product->id }}</td>

                    <td>

                        @if($product->image)

                            <img src="{{ asset('storage/'.$product->image) }}"
                                 width="60"
                                 height="60"
                                 class="rounded border"
                                 style="object-fit:cover;">

                        @else

                            <span class="text-muted">

                                No Image

                            </span>

                        @endif

                    </td>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->category->name }}</td>

                    <td>{{ $product->brand->name }}</td>

                    <td>{{ $product->sku }}</td>

                    <td>

                        ${{ number_format($product->price,2) }}

                    </td>

                    <td>

                        {{ $product->quantity }}

                    </td>

                    <td>

                        {{ $product->max_order_quantity }}

                    </td>

                    <td>

                        @if($product->status)

                            <span class="badge bg-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                        @endif

                    </td>

                    @if(auth()->user()->hasPermission('Edit Product') || auth()->user()->hasPermission('Delete Product'))

                    <td>

                        @permission('Edit Product')

                        <a href="{{ route('products.edit',$product) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        @endpermission

                        @permission('Delete Product')

                        <form action="{{ route('products.destroy',$product) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this product?')">

                                Delete

                            </button>

                        </form>

                        @endpermission

                        @permission('View Products')

                        <a href="{{ route('products.show',$product) }}"
                           class="btn btn-info btn-sm">

                            View

                        </a>

                        @endpermission

                    </td>

                    @endif

                </tr>

            @empty

                <tr>

                    <td colspan="11" class="text-center">

                        No Products Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{ $products->links() }}

</div>

@include('products._form')

@endsection
