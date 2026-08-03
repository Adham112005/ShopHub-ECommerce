<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();

        $totalUsers = User::whereHas('role', function ($q) {
            $q->where('name', 'Customer');
        })->count();

        $totalOrders = Order::count();

        $totalRevenue = Order::where('status', 'Delivered')
            ->sum('total_price');

        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::with(['category','brand'])
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->take(10)
            ->get();

        $outOfStockProducts = Product::with(['category', 'brand'])
            ->where('quantity', 0)
            ->orderBy('name')
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalCategories',
            'totalBrands',
            'totalRevenue',
            'latestOrders',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }
}
