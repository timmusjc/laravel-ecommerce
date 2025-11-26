<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');


Route::get('/about', [MainController::class, 'about'])->name('about');

Route::get('/opinie', [MainController::class, 'opinie'])->name('opinie');

Route::post('/opinie/check', [MainController::class, 'opinie_check']);

Route::get('/category/{slug}', [MainController::class, 'category'])->name('category');

Route::get('/product/{slug}', [MainController::class, 'product'])->name('product');
