@extends('layouts.app')

@section('title','Orders')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>

        Orders

    </h2>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card shadow-sm">

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle mb-0">

            <thead class="table-dark">

            <tr>

                <th>#</th>

                <th>Customer</th>

                <th>Items</th>

                <th>Total</th>

                <th>Status</th>

                <th>Date</th>

                <th width="120">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($orders as $order)

                <tr>

                    <td>

                        #{{ $order->id }}

                    </td>

                    <td>

                        {{ $order->user->name }}

                    </td>

                    <td>

                        {{ $order->items->count() }}

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

                        {{ $order->created_at->format('d M Y') }}

                    </td>

                    <td>

                        <a href="{{ route('admin.orders.show',$order) }}"
                           class="btn btn-primary btn-sm">

                            View

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7"
                        class="text-center">

                        No Orders Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">

    {{ $orders->links() }}

</div>

@endsection