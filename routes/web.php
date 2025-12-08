<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    return view('welcome');
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
Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.user')->middleware('auth');
Route::get('/orders/create-demo', [OrderController::class, 'createDemo'])->name('orders.createDemo');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Маршруты для профиля (требуют аутентификации)
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    });
});

//Работа с корзиной
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
    Route::post('/order', [CartController::class, 'storeOrder'])->name('cart.storeOrder')->middleware('auth');

});

