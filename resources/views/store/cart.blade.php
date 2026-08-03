@extends('layouts.store')

@section('title','Cart')

@section('content')

<h2 class="mb-4">
    Shopping Cart
</h2>

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

@if($cartItems->count())

<div class="table-responsive">

<table class="table table-bordered align-middle">

<thead class="table-dark">

<tr>

<th>Product</th>

<th>Price</th>

<th>Quantity</th>

<th>Total</th>

<th>Action</th>

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

$maxQuantity = $item->product->max_order_quantity
    ? min(
        $item->product->quantity,
        $item->product->max_order_quantity
    )
    : $item->product->quantity;

$limitMessage = $item->product->max_order_quantity
    && $item->product->max_order_quantity <= $item->product->quantity
        ? 'Maximum order quantity reached'
        : 'Maximum stock reached';

@endphp

<tr>

<td>

<div class="d-flex align-items-center">

@if($item->product->image)

<img src="{{ asset('storage/'.$item->product->image) }}"
     width="70"
     height="70"
     class="rounded me-3"
     style="object-fit:cover;">

@endif

<strong>

{{ $item->product->name }}

</strong>

</div>

</td>

<td>

${{ number_format($price,2) }}

</td>

<td>

<form action="{{ route('cart.update',$item) }}"
      method="POST">

@csrf
@method('PUT')

<div class="input-group">

<button type="submit"
        name="quantity"
        value="{{ $item->quantity - 1 }}"
        class="btn btn-secondary"
        @if($item->quantity <= 1) disabled @endif>

-

</button>

<input type="text"
       value="{{ $item->quantity }}"
       class="form-control text-center"
       readonly>

<button type="submit"
        name="quantity"
        value="{{ $item->quantity + 1 }}"
        class="btn btn-secondary"
        @if($item->quantity >= $maxQuantity) disabled @endif>

+

</button>

</div>

</form>

<strong class="text-muted d-block mt-2">

Available:

<strong>{{ $item->product->quantity }}</strong>

</strong>

<strong class="text-muted d-block" >

Maximum per order:

<strong>

{{ $item->product->max_order_quantity ?? 'Unlimited' }}

</strong>

<strong><br>

@if($item->quantity >= $maxQuantity)

<strong class="text-danger" style="background-color: #d6d6d5; border-radius: 6px; padding: 4px 5px;">

{{ $limitMessage }}

</strong>

@endif

</td>

<td>

${{ number_format($subtotal,2) }}

</td>

<td>

<form action="{{ route('cart.destroy',$item) }}"
      method="POST">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">

Remove

</button>

</form>

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

<a href="{{ route('checkout.index') }}"
   class="btn btn-primary btn-lg">

Checkout

</a>

</div>

@else

<div class="alert alert-warning">

Your cart is empty.

</div>

<a href="{{ route('store.products') }}"
   class="btn btn-primary">

Continue Shopping

</a>

@endif

@endsection