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

//Administrator
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Główna strona (zamówienia)
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    // Status zamówienia
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    // Usuwanie zamówienia
    Route::delete('/orders/{order}', [AdminController::class, 'deleteOrder'])->name('orders.delete');

    // --- Zarządzanie produktami ---
    // Tworzenie
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');

    // Edytowanie
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');

    // Usuwanie
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.destroy');

    // Zarządzanie kontami
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/toggle-role', [App\Http\Controllers\AdminController::class, 'toggleRole'])->name('users.toggleRole');
});

// Dla zalogowanych
Route::middleware(['auth'])->group(function () {
    // Zamówienia
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout'); // Форма
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');     // Сохранение
    // Konto
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Nowe hasło
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    // Страница "Спасибо"
    Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('success');
    // Скачивание PDF
    Route::get('/order/invoice/{order}', [OrderController::class, 'downloadInvoice'])->name('order_pdf');
});
