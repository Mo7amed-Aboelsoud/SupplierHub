<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// الصفحة الرئيسية
Route::get('/', function () { return view('welcome'); })->name('home');

Route::middleware(['auth'])->group(function () {

    // الـ Dashboard الذكي
   Route::get('/dashboard', function () {
    if (auth()->user()->role === 'supplier') {
        return redirect()->route('dashboard.supplier');
    }
    // للمطعم: حوله لصفحة الشوب مباشرة
    return redirect()->route('shop');
})->name('dashboard');  

    // --- المورد (Supplier) ---
    Route::middleware(['can:isSupplier'])->group(function () {
        Route::get('/dashboard/supplier', [ProductController::class, 'index'])->name('dashboard.supplier');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/orders/{id}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('orders.reject');
    });

    // --- المطعم (Restaurant) ---
    Route::middleware(['can:isRestaurant'])->group(function () {
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
        Route::post('/order/place/{product_id}', [OrderController::class, 'placeOrder'])->name('order.place');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    // صفحة المتجر (للكل)
    Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
