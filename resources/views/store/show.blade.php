@extends('layouts.store')

@section('title', $product->name)

@section('content')

<div class="row">

    <div class="col-md-5">

        @if($product->image)

            <img src="{{ asset('storage/'.$product->image) }}"
                 class="img-fluid rounded shadow">

        @else

            <div class="border rounded d-flex justify-content-center align-items-center"
                 style="height:450px;">

                No Image

            </div>

        @endif

    </div>

    <div class="col-md-7">

        <h2>{{ $product->name }}</h2>

        <p class="text-muted">
            SKU:
            <strong>{{ $product->sku }}</strong>
        </p>

        <p>
            Category:
            <strong>{{ $product->category->name }}</strong>
        </p>

        <p>
            Brand:
            <strong>{{ $product->brand->name }}</strong>
        </p>

        @if($product->discount_price)

            <h3 class="text-danger">

                ${{ number_format($product->discount_price,2) }}

            </h3>

            <h5 class="text-decoration-line-through text-muted">

                ${{ number_format($product->price,2) }}

            </h5>

        @else

            <h3>

                ${{ number_format($product->price,2) }}

            </h3>

        @endif

        <p class="mt-3">

            @if($product->quantity > 0)

                <span class="badge bg-success">

                    In Stock

                </span>

                <span class="ms-2">

                    {{ $product->quantity }} Available

                </span>

            @else

                <span class="badge bg-danger">

                    Out of Stock

                </span>

            @endif

        </p>

        <hr>

        <h5>

            Description

        </h5>

        <p>

            {{ $product->description ?: 'No description available.' }}

        </p>

        <div class="mt-4">

            @auth

                @if($product->quantity > 0)

                    @php
                        $maxQuantity = min(
                            $product->quantity,
                            $product->max_order_quantity
                        );
                    @endphp

                    <form action="{{ route('cart.store',$product) }}"
                          method="POST">

                        @csrf

                        <div class="input-group mb-3">

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="decreaseQty()">

                                -

                            </button>

                            <input type="number"
                                   id="quantity"
                                   name="quantity"
                                   value="1"
                                   min="1"
                                   max="{{ $maxQuantity }}"
                                   class="form-control text-center">

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="increaseQty()">

                                +

                            </button>

                        </div>

                        <small class="text-muted d-block mb-3">

                            Available Stock:
                            <strong>{{ $product->quantity }}</strong>

                            |

                            Maximum Per Order:
                            <strong>{{ $product->max_order_quantity }}</strong>

                        </small>

                        <button type="submit"
                                class="btn btn-success btn-lg">

                            <i class="bi bi-cart-plus"></i>

                            Add To Cart

                        </button>

                    </form>

                @else

                    <button class="btn btn-danger btn-lg"
                            disabled>

                        Out Of Stock

                    </button>

                @endif

            @else

                <a href="{{ route('login') }}"
                   class="btn btn-success btn-lg">

                    Login To Add Cart

                </a>

            @endauth

            <a href="{{ route('store.products') }}"
               class="btn btn-outline-secondary btn-lg">

                Continue Shopping

            </a>

        </div>

    </div>

</div>

<script>

function increaseQty(){

    let input = document.getElementById('quantity');

    let max = parseInt(input.max);

    if(parseInt(input.value) < max){

        input.value++;

    }else{

        alert('Maximum quantity reached');

    }

}

function decreaseQty(){

    let input = document.getElementById('quantity');

    if(parseInt(input.value) > 1){

        input.value--;

    }

}

</script>

@endsection