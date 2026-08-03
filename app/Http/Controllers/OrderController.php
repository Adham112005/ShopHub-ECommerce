<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('store.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id != auth()->id(), 403);

        $order->load([
            'items.product',
            'logs.user',
        ]);

        return view('store.orders.show', compact('order'));
    }

public function cancel(Order $order): RedirectResponse
{
    abort_if($order->user_id !== auth()->id(), 403);

    if ($order->status !== 'Pending') {

        return back()->with(
            'error',
            'This order can no longer be cancelled.'
        );
    }

    $order->update([
        'status' => 'Cancelled',
    ]);

    $order->logs()->create([
        'status' => 'Cancelled',
        'note' => 'Order cancelled by customer.',
        'user_id' => auth()->id(),
    ]);

    return back()->with(
        'success',
        'Order cancelled successfully.'
    );
}
}
