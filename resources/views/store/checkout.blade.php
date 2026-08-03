@extends('layouts.store')

@section('title','Checkout')

@section('content')

<h2 class="mb-4">

    Checkout

</h2>

@if(session('error'))

<div class="alert alert-danger">

    {{ session('error') }}

</div>

@endif

@if($cartItems->count())

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>
                        <th>
                            Product
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Quantity
                        </th>

                        <th>
                            Total
                        </th>
                    </tr>

                </thead>

                <tbody>

                @php

                    $total = 0;

                @endphp

                @foreach($cartItems as $item)

                    @php

                        $price = $item->product->discount_price 
                                ?? $item->product->price;

                        $subtotal = $price * $item->quantity;

                        $total += $subtotal;

                    @endphp

                    <tr>
                        <td>

                            {{ $item->product->name }}

                        </td>

                        <td>

                            ${{ number_format($price,2) }}

                        </td>

                        <td>

                            {{ $item->quantity }}

                        </td>

                        <td>

                            ${{ number_format($subtotal,2) }}

                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>

        <div class="text-end">

            <h4>
                Total:

                <span class="text-success">

                    ${{ number_format($total,2) }}

                </span>
            </h4>

            <form action="{{ route('checkout.store') }}"
                  method="POST">

                @csrf

                <button class="btn btn-primary btn-lg">

                    Confirm Order

                </button>
            </form>


        </div>

    </div>

</div>

@else

<div class="alert alert-warning">

    Your cart is empty.

</div>

@endif

@endsection