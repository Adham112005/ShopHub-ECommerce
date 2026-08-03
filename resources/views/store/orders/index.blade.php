@extends('layouts.store')

@section('title','My Orders')


@section('content')


<h2 class="mb-4">

    My Orders

</h2>



@if($orders->count())


<div class="table-responsive">


<table class="table table-bordered align-middle">


<thead class="table-dark">

<tr>

<th>
Order #
</th>

<th>
Name
</th>

<th>
Total
</th>

<th>
Status
</th>

<th>
Date
</th>

<th>
Action
</th>

</tr>

</thead>



<tbody>


@foreach($orders as $order)


<tr>


<td>

#{{ $order->id }}

</td>

    <td>

        @foreach($order->items as $item)

            <div>

                - {{ $item->product->name }}

                <span class="text-muted">

                   = (x{{ $item->quantity }})

                </span>

            </div>

        @endforeach

    </td>

<td>

${{ number_format($order->total_price,2) }}

</td>



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

@endswitch


</td>



<td>

{{ $order->created_at->format('d M Y h:i A') }}

</td>



<td>

    <a href="{{ route('orders.show',$order) }}"
       class="btn btn-primary btn-sm">

        View

    </a>

    @if($order->status == 'Pending')

        <form action="{{ route('orders.cancel',$order) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('PUT')

            <button
                class="btn btn-danger btn-sm"
                onclick="return confirm('Cancel this order?')">

                Cancel

            </button>

        </form>

    @endif

</td>


</tr>


@endforeach


</tbody>


</table>


</div>


@else


<div class="alert alert-warning">

No Orders Found.

</div>


<a href="{{ route('store.products') }}"
   class="btn btn-primary">

Start Shopping

</a>


@endif



@endsection