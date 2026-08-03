@extends('layouts.app')

@section('title','Order Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        Order #{{ $order->id }}
    </h2>

    <a href="{{ route('admin.orders.index') }}"
       class="btn btn-secondary">

        ← Back

    </a>

</div>

<div class="row">

    {{-- Left Side --}}
    <div class="col-md-4">

        <div class="card shadow-sm mb-4">

            <div class="card-header">

                Customer Information

            </div>

            <div class="card-body">

                <p>
                    <strong>Name:</strong>
                    {{ $order->user->name }}
                </p>

                <p>
                    <strong>Email:</strong>
                    {{ $order->user->email }}
                </p>

                <p>
                    <strong>Order Date:</strong>
                    {{ $order->created_at->format('d M Y h:i A') }}
                </p>

                <p>
                    <strong>Total:</strong>
                    ${{ number_format($order->total_price,2) }}
                </p>

                <p>

                    <strong>Status:</strong>

                    @switch($order->status)

                        @case('Pending')
                            <span class="badge bg-warning">Pending</span>
                            @break

                        @case('Processing')
                            <span class="badge bg-info">Processing</span>
                            @break

                        @case('Shipped')
                            <span class="badge bg-primary">Shipped</span>
                            @break

                        @case('Delivered')
                            <span class="badge bg-success">Delivered</span>
                            @break

                        @case('Cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                            @break

                    @endswitch

                </p>

            </div>

        </div>


        <div class="card shadow-sm">

            <div class="card-header">

                Change Status

            </div>

            <div class="card-body">

                <form action="{{ route('admin.orders.status',$order) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <select name="status"
                                class="form-select">

                            <option value="Pending"
                                @selected($order->status=='Pending')>

                                Pending

                            </option>

                            <option value="Processing"
                                @selected($order->status=='Processing')>

                                Processing

                            </option>

                            <option value="Shipped"
                                @selected($order->status=='Shipped')>

                                Shipped

                            </option>

                            <option value="Delivered"
                                @selected($order->status=='Delivered')>

                                Delivered

                            </option>

                            <option value="Cancelled"
                                @selected($order->status=='Cancelled')>

                                Cancelled

                            </option>

                        </select>

                    </div>

                    <button class="btn btn-success w-100">

                        Update Status

                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- Right Side --}}
    <div class="col-md-8">

        <div class="card shadow-sm">

            <div class="card-header">

                Ordered Products

            </div>

            <div class="table-responsive">

                <table class="table table-bordered mb-0">

                    <thead class="table-dark">

                    <tr>

                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($order->items as $item)

                        <tr>

                            <td width="90">

                                @if($item->product->image)

                                    <img src="{{ asset('storage/'.$item->product->image) }}"
                                         width="70"
                                         class="rounded">

                                @endif

                            </td>

                            <td>

                                {{ $item->product->name }}

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

                        <th>

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

                            @if($log->user)

                                <div class="text-secondary small">

                                    By {{ $log->user->name }}

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

    </div>

</div>

@endsection