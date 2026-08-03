<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ProductController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        $brands = Brand::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');

        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'brand']);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        $brands = Brand::orderBy('name')->get();

        return view('products.index', [

            'products' => $products,

            'categories' => $categories,

            'brands' => $brands,

            'editProduct' => $product,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            if ($product->image && Storage::disk('public')->exists($product->image)) {

                Storage::disk('public')->delete($product->image);

            }

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {

            Storage::disk('public')->delete($product->image);

        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Products', only: ['index']),

            new Middleware('permission:Add Product', only: ['store']),

            new Middleware('permission:Edit Product', only: ['edit', 'update']),

            new Middleware('permission:Delete Product', only: ['destroy']),

        ];
    }
}
