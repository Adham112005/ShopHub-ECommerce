<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function home(): View
    {
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->where('featured', 1)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        return view('store.home', compact(
            'featuredProducts',
            'latestProducts'
        ));
    }

    public function products(Request $request)
    {
        $products = Product::with(['category','brand'])
            ->where('status', true);

        // Search
        if ($request->filled('search')) {

            $products->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Category Filter
        if ($request->filled('category')) {

            $products->where('category_id', $request->category);
        }

        // Brand Filter
        if ($request->filled('brand')) {

            $products->where('brand_id', $request->brand);
        }

        // Products On Sale
        if ($request->filled('discount')) {

            $products->whereNotNull('discount_price');
        }

        // Sorting
        switch ($request->sort) {

            case 'price_low':
                $products->orderBy('price');

                break;

            case 'price_high':
                $products->orderByDesc('price');

                break;

            case 'oldest':
                $products->oldest();

                break;

            default:
                $products->latest();
        }

        $products = $products
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('store.products', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    public function show(Product $product): View
    {
        return view('store.show', compact('product'));
    }
}
