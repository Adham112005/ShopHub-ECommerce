<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\View\View;
use App\Models\OrderLog;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with([
            'user',
            'items'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load([
            'user',
            'items.product',
            'logs.user',
        ]);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled',
        ]);

        DB::transaction(function () use ($request, $order) {

            // خصم الكمية مرة واحدة فقط عند التسليم
            if (
                $request->status === 'Delivered' &&
                $order->status !== 'Delivered'
            ) {

                foreach ($order->items as $item) {

                    $product = $item->product;

                    if ($product) {

                        if ($product->quantity < $item->quantity) {

                            abort(
                                422,
                                "Not enough stock for {$product->name}"
                            );

                        }

                        $product->decrement(
                            'quantity',
                            $item->quantity
                        );
                    }
                }
            }

            $order->update([
                'status' => $request->status
            ]);

            OrderLog::create([

                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'status' => $request->status,
                'note' => 'Status changed to '.$request->status,
            ]);

        });

        return back()->with(
            'success',
            'Order status updated successfully.'
        );
    }
}
