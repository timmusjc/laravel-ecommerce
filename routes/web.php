<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;


Route::get('/', [MainController::class, 'home'])->name('home');

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/categories', [MainController::class, 'categories'])->name('categories');

Route::get('/search', [MainController::class, 'search'])->name('search');

Route::get('/about', [MainController::class, 'about'])->name('about');

Route::get('/opinie', [MainController::class, 'opinie'])->name('opinie');

Route::post('/opinie/check', [MainController::class, 'opinie_check']);

Auth::routes();

Route::get('/cart', [CartController::class, 'cart'])->name('cart');








Route::post('/cart/add/{id}', [CartController::class, 'cartAdd'])->name('cart.add');

Route::post('/cart/remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');

Route::patch('/cart/update', [CartController::class, 'cartUpdate'])->name('cart.update');

Route::get('/category/{slug}', [MainController::class, 'category'])->name('category');

Route::get('/product/{slug}', [MainController::class, 'product'])->name('product');

Route::middleware(['auth', 'admin'])->group(function () 
{
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout'); // Форма
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');     // Сохранение
});


