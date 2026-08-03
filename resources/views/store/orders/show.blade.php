@extends('layouts.store')

@section('title','Order Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>

        Order #{{ $order->id }}

    </h2>

    <a href="{{ route('orders.index') }}"
       class="btn btn-secondary">

        ← Back

    </a>

</div>

<div class="card mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <strong>Status</strong>

                <br>

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

            </div>

            <div class="col-md-4">

                <strong>Date</strong>

                <br>

                {{ $order->created_at->format('d M Y h:i A') }}

            </div>

            <div class="col-md-4">

                <strong>Total</strong>

                <br>

                <span class="fw-bold text-success">

                    ${{ number_format($order->total_price,2) }}

                </span>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <h5 class="mb-0">

            Ordered Products

        </h5>

    </div>

    <div class="card-body p-0">

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-dark">

            <tr>

                <th width="90">Image</th>

                <th>Product</th>

                <th>Price</th>

                <th>Quantity</th>

                <th>Subtotal</th>

            </tr>

            </thead>

            <tbody>

            @foreach($order->items as $item)

                <tr>

                    <td>

                        @if($item->product && $item->product->image)

                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 width="70"
                                 class="rounded">

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        {{ $item->product->name ?? 'Product Deleted' }}

                    </td>

                    <td>

                        ${{ number_format($item->price,2) }}

                    </td>

                    <td>

                        {{ $item->quantity }}

                    </td>

                    <td>

                        ${{ number_format($item->price * $item->quantity,2) }}

                    </td>

                </tr>

            @endforeach

            </tbody>

            <tfoot>

            <tr>

                <th colspan="4"
                    class="text-end">

                    Grand Total

                </th>

                <th class="text-success">

                    ${{ number_format($order->total_price,2) }}

                </th>

            </tr>

            </tfoot>

        </table>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        <i class="bi bi-clock-history me-2"></i>

        Order Timeline

    </div>

    <div class="card-body">

        @forelse($order->logs as $log)

            <div class="d-flex mb-3">

                <div class="me-3">

                    <span class="badge bg-primary rounded-pill p-2">

                        <i class="bi bi-check-lg"></i>

                    </span>

                </div>

                <div>

                    <strong>

                        {{ $log->status }}

                    </strong>

                    <br>

                    <small class="text-muted">

                        {{ $log->created_at->format('d M Y - h:i A') }}

                    </small>

                    @if($log->note)

                        <div class="mt-1">

                            {{ $log->note }}

                        </div>

                    @endif

                </div>

            </div>

            @unless($loop->last)

                <hr>

            @endunless

        @empty

            <p class="text-muted mb-0">

                No history available.

            </p>

        @endforelse

    </div>

</div>

@endsection