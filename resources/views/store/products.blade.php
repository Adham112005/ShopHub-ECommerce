@extends('layouts.store')

@section('title', 'Products')

@section('content')

<h2 class="mb-4">
    All Products
</h2>

<form method="GET"
      action="{{ route('store.products') }}"
      class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-3">

                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search products..."
                    value="{{ request('search') }}">

            </div>

                <div class="col-md-2">

                <div class="form-check mt-2">

                    <input class="form-check-input"
                        type="checkbox"
                        name="discount"
                        value="1"
                        id="discount"

                        {{ request('discount') ? 'checked' : '' }}>

                    <label class="form-check-label"
                        for="discount">

                        Discounted Products

                    </label>

                </div>

            </div>
            
                <div class="col-md-2">

                    <select name="category"
                            class="form-select">

                    <option value="">
                    All Categories
                    </option>

                    @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        @selected(request('category')==$category->id)>

                    {{ $category->name }}

                    </option>

                    @endforeach
                    </select>

                </div>

                <div class="col-md-2">

                    <select name="brand"
                            class="form-select">

                    <option value="">
                    All Brands
                    </option>

                    @foreach($brands as $brand)

                    <option value="{{ $brand->id }}"
                        @selected(request('brand')==$brand->id)>

                    {{ $brand->name }}

                    </option>

                    @endforeach
                    </select>

                </div>



            <div class="col-md-2">

                <select name="sort"
                        class="form-select">

                    <option value="">
                    Newest
                    </option>

                    <option value="price_low"
                    @selected(request('sort')=='price_low')>

                    Price: Low → High

                    </option>

                    <option value="price_high"
                    @selected(request('sort')=='price_high')>

                    Price: High → Low

                    </option>

                    <option value="oldest"
                    @selected(request('sort')=='oldest')>

                    Oldest

                    </option>
                </select>

            </div>

                <div class="col-md-1 d-grid">

                    <button class="btn btn-primary">

                    <i class="bi bi-search"></i>

                    </button>

                </div>

        </div>

    </div>

</form>

<div class="row">

@forelse($products as $product)

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card h-100 shadow-sm">

@if($product->image)

<img
src="{{ asset('storage/'.$product->image) }}"
class="card-img-top"
style="height:290px; width:100%; object-fit:contain; padding:5px; border-bottom:1px solid #ddd; border-radius:25px; object-fit:cover;">

@else

<div
class="bg-light d-flex justify-content-center align-items-center"
style="height:230px;">

No Image

</div>

@endif

<div class="card-body">

<small class="text-muted">

{{ $product->category->name }}

</small>

<h5 class="mt-2">

{{ $product->name }}

</h5>

<p class="text-muted mb-1">

{{ $product->brand->name }}

</p>

@if($product->discount_price)

<h5 class="text-danger">

${{ number_format($product->discount_price,2) }}

</h5>

<small class="text-decoration-line-through text-muted">

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
        class="btn btn-secondary"
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
        class="btn btn-secondary"
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
<strong>{{ $product->max_order_quantity ?? $product->quantity }}</strong>

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

<button class="btn btn-danger w-100"
        disabled>

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

@empty

<div class="col-12">

<div class="alert alert-warning">

No Products Found.

</div>

</div>

@endforelse

</div>

<div class="d-flex justify-content-center mt-4">

{{ $products->links() }}

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
    let value = parseInt(input.value);

    let message = input.parentElement
        .parentElement
        .querySelector('.max-message');

    if(value >= max){

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