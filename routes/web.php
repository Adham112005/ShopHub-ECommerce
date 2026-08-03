<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;

/*=========================================================*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

});
/*==========================================================*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
    
    Route::get('/cart',[CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/{product}',
        [CartController::class, 'store']
    )->name('cart.store');

    Route::put('/cart/{cart}',
        [CartController::class,'update']
    )->name('cart.update');

    Route::delete('/cart/{cart}',[CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::get('/checkout',[CheckoutController::class,'index'])
        ->name('checkout.index');

    Route::post('/checkout',[CheckoutController::class,'store'])
        ->name('checkout.store');

    Route::get('/orders',
        [OrderController::class,'index']
    )
    ->name('orders.index');

    Route::get('/orders/{order}',
        [OrderController::class,'show']
    )
    ->name('orders.show');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Roles
    Route::resource('roles', RoleController::class)
        ->except(['create', 'show']);

    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->middleware('permission:Assign Permissions')
        ->name('roles.permissions');

    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->middleware('permission:Assign Permissions')
        ->name('roles.permissions.update');

// Users
    Route::resource('users', UserController::class)
    ->except(['create','show',]);

// Permissions
    Route::resource('permissions', PermissionController::class)
    ->except(['create','show',]);

// Category
Route::resource('categories', CategoryController::class)
    ->except(['create', 'show']);

// Brand
Route::resource('brands', BrandController::class)
    ->except(['create', 'show']);

// Product
Route::resource('products', ProductController::class)
    ->except(['create']);

});

Route::prefix('admin')->group(function () {

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::put(
        '/orders/{order}/status',
        [AdminOrderController::class,'updateStatus']
    )->name('admin.orders.status');

});

Route::get('/', [StoreController::class, 'home'])
    ->name('store.home');

Route::get('/shop/products', [StoreController::class, 'products'])
    ->name('store.products');

Route::get('/shop/products/{product}', [StoreController::class, 'show'])
    ->name('store.show');

Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel');
