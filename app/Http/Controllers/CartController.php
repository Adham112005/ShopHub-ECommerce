<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('store.cart', compact('cartItems'));
    }

    public function store(Product $product)
    {
        $quantity = request('quantity',1);

        $maxQuantity = $product->max_order_quantity
            ? min(
                $product->quantity,
                $product->max_order_quantity
            )
            : $product->quantity;

        if($quantity > $maxQuantity){

            return back()
                ->with(
                    'error',
                    'Maximum allowed quantity is '.$maxQuantity
                );
        }

        $cart = Cart::where('user_id',auth()->id())
            ->where('product_id',$product->id)
            ->first();

        if($cart){

            $newQuantity = $cart->quantity + $quantity;

            if($newQuantity > $maxQuantity){

                return back()
                    ->with(
                        'error',
                        'You can order maximum '.$maxQuantity.' items'
                    );
            }

            $cart->update([
                'quantity'=>$newQuantity
            ]);

        }else{

            Cart::create([

                'user_id'=>auth()->id(),
                'product_id'=>$product->id,
                'quantity'=>$quantity,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Product added to cart'
            );
    }

    public function update(Request $request, Cart $cart)
    {
        if($cart->user_id !== auth()->id()){

            abort(403);
        }

        $request->validate([

            'quantity'=>'required|integer|min:1'
        ]);

        $product = $cart->product;

        $maxQuantity = $product->max_order_quantity
            ? min(
                $product->quantity,
                $product->max_order_quantity
            )
            : $product->quantity;

        if($request->quantity > $maxQuantity){

            return back()
                ->with(
                    'error',
                    'Maximum allowed quantity is '.$maxQuantity
                );
        }

        $cart->update([

            'quantity'=>$request->quantity
        ]);

        return back()
            ->with(
                'success',
                'Cart updated'
            );
    }

    public function destroy(Cart $cart)
    {
        if($cart->user_id !== auth()->id()){

            abort(403);
        }

        $cart->delete();

        return back()
            ->with(
                'success',
                'Product removed from cart'
            );
    }
}
