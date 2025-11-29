<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori', [HomeController::class, 'kategori'])->name('kategori');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/produk/{id}', [HomeController::class, 'productDetail'])->name('product.detail');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
});

// User Dashboard Routes
Route::prefix('dashboard/user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'userDashboard'])->name('dashboard');
    
    Route::get('/checkout', function () {
        return view('dashboard.user.checkout');
    })->name('checkout');
    
    Route::get('/profile', function () {
        return view('dashboard.user.profile');
    })->name('profile');
    
    Route::get('/settings', function () {
        return view('dashboard.user.settings');
    })->name('settings');
});

// Admin Dashboard Routes
Route::prefix('dashboard/admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/users', function () {
        return view('dashboard.admin.users');
    })->name('users');
    
    Route::get('/users/create', function () {
        return view('dashboard.admin.users-create');
    })->name('users.create');
    
    Route::get('/settings', function () {
        return view('dashboard.admin.settings');
    })->name('settings');
    
    Route::get('/reports', function () {
        return view('dashboard.admin.reports');
    })->name('reports');
    
    // Product Management Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::get('/products/categories', [CategoryController::class, 'index'])->name('products.categories');
    Route::post('/products/categories', [CategoryController::class, 'store'])->name('products.categories.store');
    Route::put('/products/categories/{category}', [CategoryController::class, 'update'])->name('products.categories.update');
    Route::delete('/products/categories/{category}', [CategoryController::class, 'destroy'])->name('products.categories.destroy');
    
    // Additional admin routes will be added here
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    
    Route::get('/orders/{id}', function () {
        return view('dashboard.admin.orders.detail');
    })->name('orders.detail');
    
    Route::get('/stock', [StockController::class, 'index'])->name('stock');
    
    Route::get('/stock/input', function () {
        return view('dashboard.admin.stock.index');
    })->name('stock.input');
    
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    
    Route::get('/promo', [PromoController::class, 'index'])->name('promo');
    Route::resource('promo', PromoController::class)->except(['index']);
    
    // Sales Summary Route
    Route::get('/sales-summary', function () {
        return view('dashboard.admin.sales-summary');
    })->name('sales-summary');
});

// Authentication Routes
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return response('Halaman registrasi belum tersedia. Silakan kembali ke beranda.', 200);
})->name('register');
