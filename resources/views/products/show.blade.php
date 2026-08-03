@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Product Details
        </h2>

        <a href="{{ route('products.index') }}"
           class="btn btn-secondary">

            ← Back

        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/'.$product->image) }}"
                            class="img-fluid rounded border"
                            style="max-height:300px; object-fit:contain;">

                    @else

                        <div class="border rounded p-5 text-muted">

                            No Image

                        </div>

                    @endif

                </div>

                <div class="col-md-8">

                    <table class="table table-bordered">

                        <tr>

                            <th width="220">
                                Product Name
                            </th>

                            <td>
                                {{ $product->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Category
                            </th>

                            <td>
                                {{ $product->category->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Brand
                            </th>

                            <td>
                                {{ $product->brand->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                SKU
                            </th>

                            <td>
                                {{ $product->sku }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Price
                            </th>

                            <td>
                                ${{ number_format($product->price,2) }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Discount Price
                            </th>

                            <td>

                                @if($product->discount_price)

                                    ${{ number_format($product->discount_price,2) }}

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Quantity
                            </th>

                            <td>
                                {{ $product->quantity }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Maximum Order Quantity
                            </th>

                            <td>
                                {{ $product->max_order_quantity ?? '-' }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Featured
                            </th>

                            <td>

                                @if($product->featured)

                                    <span class="badge bg-warning text-dark">

                                        Yes

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        No

                                    </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Status
                            </th>

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

                        </tr>

                        <tr>

                            <th>
                                Description
                            </th>

                            <td>

                                {!! nl2br(e($product->description ?? '-')) !!}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Created At
                            </th>

                            <td>

                                {{ $product->created_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                        <tr>

                            <th>
                                Updated At
                            </th>

                            <td>

                                {{ $product->updated_at->format('d M Y h:i A') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection