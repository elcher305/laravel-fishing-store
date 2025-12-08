<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

// Аутентификация
Route::controller(AuthController::class)->group(function () {
    // Регистрация
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    // Вход
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    // Выход
    Route::post('/logout', 'logout')->name('logout');

    // Восстановление пароля
    Route::get('/forgot-password', 'showForgotPassword')
        ->name('password.request');
    Route::post('/forgot-password', 'forgotPassword')
        ->name('password.email');
});

// Защищенные маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

// Если нужно, добавьте эту строку для проверки маршрутов
Route::get('/routes', function () {
    return \Route::getRoutes();
});

// Маршруты для управления товарами
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});


// Маршруты для управления заказами
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create-demo', [OrderController::class, 'createDemo'])->name('orders.createDemo');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

