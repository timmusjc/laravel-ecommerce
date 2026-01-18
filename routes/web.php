<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [MainController::class, 'home'])->name('home');

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
    // Главная админки (Заказы)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // Статус заказа
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');

    // --- УПРАВЛЕНИЕ ТОВАРАМИ ---
    
    // 1. Создание
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    
    // 2. Редактирование (Форма + Сохранение)
    Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');

    // 3. Удаление
    Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout'); // Форма
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');     // Сохранение
    // Профиль
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // НОВЫЙ МАРШРУТ ДЛЯ ПАРОЛЯ
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


