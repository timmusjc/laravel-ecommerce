<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CartController;


Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');


Route::get('/about', [MainController::class, 'about'])->name('about');

Route::get('/opinie', [MainController::class, 'opinie'])->name('opinie');

Route::post('/opinie/check', [MainController::class, 'opinie_check']);

Route::get('/cart', [CartController::class, 'cart'])->name('cart');

Route::get('/search', [MainController::class, 'search'])->name('search');







Route::post('/cart/add/{id}', [CartController::class, 'cartAdd'])->name('cart.add');

Route::post('/cart/remove/{id}', [CartController::class, 'cartRemove'])->name('cart.remove');

Route::patch('/cart/update', [CartController::class, 'cartUpdate'])->name('cart.update');

Route::get('/category/{slug}', [MainController::class, 'category'])->name('category');

Route::get('/product/{slug}', [MainController::class, 'product'])->name('product');

