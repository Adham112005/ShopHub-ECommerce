@extends('layouts.store')

@section('title', 'Home')

@section('content')

<div class="mb-5">

    <div class="p-5 text-center bg-primary text-white rounded">

        <h1>
            Welcome to ShopHub
        </h1>

        <p class="lead">
            Discover the latest products at the best prices.
        </p>

        <a href="{{ route('store.products') }}"
           class="btn btn-light btn-lg">

            Shop Now

        </a>

    </div>

</div>

@if($featuredProducts->count())

<div class="mb-5">

<h2 class="mb-4">
    ⭐ Featured Products
</h2>

<div class="row">

@foreach($featuredProducts as $product)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm">

@if($product->image)

<img src="{{ asset('storage/'.$product->image) }}"
     class="card-img-top"
     style="height:290px; width:100%; object-fit:contain; padding:5px; border-bottom:1px solid #ddd;">

@else

<div class="d-flex align-items-center justify-content-center bg-light"
     style="height:220px;">

    No Image

</div>

@endif

<div class="card-body">

<h5>
    {{ $product->name }}
</h5>

<p class="text-muted">
    {{ $product->brand->name }}
</p>

@if($product->discount_price)

<h5 class="text-danger">
    ${{ number_format($product->discount_price,2) }}
</h5>

<small class="text-decoration-line-through">
    ${{ number_format($product->price,2) }}
</small>

@else

<h5>
    ${{ number_format($product->price,2) }}
</h5>

@endif

</div>

<div class="card-footer bg-white">

<a href="{{ route('store.show',$product) }}"
   class="btn btn-outline-primary w-100 mb-2">

    View Product

</a>

@auth

@if($product->quantity > 0)

<form action="{{ route('cart.store',$product) }}"
      method="POST">

@csrf

@php

$maxQuantity = $product->max_order_quantity
    ? min($product->quantity, $product->max_order_quantity)
    : $product->quantity;

$limitType = ($product->max_order_quantity && $product->max_order_quantity <= $product->quantity)
    ? 'order'
    : 'stock';

@endphp

<div class="input-group mb-2">

<button type="button"
        class="btn btn-outline-secondary"
        onclick="changeQty(this,-1)">

-

</button>

<input type="number"
       name="quantity"
       value="1"
       min="1"
       max="{{ $maxQuantity }}"
       data-limit-type="{{ $limitType }}"
       class="form-control text-center quantity-input"
       oninput="checkMax(this)">

<button type="button"
        class="btn btn-outline-secondary"
        onclick="changeQty(this,1)">

+

</button>

</div>

<strong class="text-muted d-block">

Available:
<strong>{{ $product->quantity }}</strong>

</strong>

<strong class="text-muted d-block mb-2" style="background-color:  #fea445; border-radius: 6px; padding: 4px 5px;">

Maximum per order:
<strong>{{ $product->max_order_quantity ?: 'Unlimited' }}</strong>

</strong>

<strong class="text-danger max-message"
        style="display:none;">
</strong>

<button class="btn btn-success w-100">

<i class="bi bi-cart-plus"></i>

Add To Cart

</button>

</form>

@else

<button class="btn btn-danger w-100" disabled>

Out Of Stock

</button>

@endif

@else

<a href="{{ route('login') }}"
   class="btn btn-success w-100">

Login To Add Cart

</a>

@endauth

</div>

</div>

</div>

@endforeach

</div>

</div>

@endif

<div>

<h2 class="mb-4">

New Arrivals

</h2>

<div class="row">

@foreach($latestProducts as $product)

<div class="col-md-3 mb-4">

<div class="card h-100 shadow-sm">

@if($product->image)

<img src="{{ asset('storage/'.$product->image) }}"
     class="card-img-top rounded-4"
     style="height:290px; width:100%; object-fit:contain; padding:5px; border-bottom:1px solid #ddd; border-radius: 30px; object-fit:cover;">

@else

<div class="d-flex align-items-center justify-content-center bg-light"
     style="height:220px;">

No Image

</div>

@endif

<div class="card-body">

<h5>

{{ $product->name }}

</h5>

<p class="text-muted">

{{ $product->category->name }}

</p>

<h5>

${{ number_format($product->discount_price ?: $product->price,2) }}

</h5>

</div>

<div class="card-footer bg-white">

<a href="{{ route('store.show',$product) }}"
   class="btn btn-outline-primary w-100 mb-2">

View Details

</a>

@auth

@if($product->quantity > 0)

<form action="{{ route('cart.store',$product) }}"
      method="POST">

@csrf

@php

$maxQuantity = $product->max_order_quantity
    ? min($product->quantity, $product->max_order_quantity)
    : $product->quantity;

$limitType = ($product->max_order_quantity && $product->max_order_quantity <= $product->quantity)
    ? 'order'
    : 'stock';

@endphp

<div class="input-group mb-2">

<button type="button"
        class="btn btn-outline-secondary"
        onclick="changeQty(this,-1)">

-

</button>

<input type="number"
       name="quantity"
       value="1"
       min="1"
       max="{{ $maxQuantity }}"
       data-limit-type="{{ $limitType }}"
       class="form-control text-center quantity-input"
       oninput="checkMax(this)">

<button type="button"
        class="btn btn-outline-secondary"
        onclick="changeQty(this,1)">
+

</button>

</div>

<strong class="text-muted d-block">

Available:
<strong>{{ $product->quantity }}</strong>

</strong>

<strong class="text-muted d-block mb-2" style="background-color:  #fea445; border-radius: 6px; padding: 4px 5px;">

Maximum per order:
<strong>{{ $product->max_order_quantity ?: 'Unlimited' }}</strong>

</strong>

<strong class="text-danger max-message"
        style="display:none;">
</strong>

<button class="btn btn-success w-100">

<i class="bi bi-cart-plus"></i>

Add To Cart

</button>

</form>

@else

<button class="btn btn-danger w-100" disabled>

Out Of Stock

</button>

@endif

@else

<a href="{{ route('login') }}"
   class="btn btn-success w-100">

Login To Add Cart

</a>

@endauth

</div>

</div>

</div>

@endforeach

</div>

</div>

<script>

function changeQty(button, amount)
{
    let input = button.parentElement.querySelector('.quantity-input');

    let value = parseInt(input.value);
    let min = parseInt(input.min);
    let max = parseInt(input.max);

    value += amount;

    if(value < min){
        value = min;
    }

    if(value > max){
        value = max;
    }

    input.value = value;

    checkMax(input);
}

function checkMax(input)
{
    let max = parseInt(input.max);

    let message = input.closest('form')
        .querySelector('.max-message');

    if(parseInt(input.value) >= max){

        if(input.dataset.limitType === 'order'){

            message.innerText = 'Maximum order quantity reached';

        }else{

            message.innerText = 'Maximum stock reached';

        }

        message.style.display = 'block';

    }else{

        message.style.display = 'none';

    }
}

</script>

@endsection