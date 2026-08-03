<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('store.checkout', compact('cartItems'));
    }

    public function store()
{
    $cartItems = Cart::with('product')
        ->where('user_id', auth()->id())
        ->get();



    if ($cartItems->isEmpty()) {

        return redirect()
            ->route('cart.index')
            ->with('error','Your cart is empty');

    }



    // Check stock and maximum order quantity

    foreach ($cartItems as $item) {


        if($item->quantity > $item->product->quantity){

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    $item->product->name.' exceeds available stock'
                );

        }



        if($item->quantity > $item->product->max_order_quantity){

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Maximum order quantity for '
                    .$item->product->name
                    .' is '
                    .$item->product->max_order_quantity
                );
        }
    }

    DB::transaction(function () use ($cartItems) {

        $total = 0;

        foreach ($cartItems as $item) {

            $price = $item->product->discount_price
                ?? $item->product->price;

            $total += $price * $item->quantity;
        }

        $order = Order::create([

            'user_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'Pending',
        ]);

        OrderLog::create([

            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'note' => 'Order created',
        ]);

        foreach ($cartItems as $item) {

            $price = $item->product->discount_price
                ?? $item->product->price;

            OrderItem::create([

                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);

            // decrease product stock
            $item->product->decrement(
                'quantity',
                $item->quantity
            );
        }

        Cart::where('user_id', auth()->id())
            ->delete();
    });

    return redirect()
        ->route('orders.index')
        ->with('success','Order placed successfully');
}
}
