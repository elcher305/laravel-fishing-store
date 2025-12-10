<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Регистрация
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Вход/выход
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Восстановление пароля
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Защищенные маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Профиль пользователя
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    });

});

// Маршруты для товаров с префиксом 'admin'
Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
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

//// Маршруты для профиля (требуют аутентификации)
//Route::middleware('auth')->group(function () {
//    Route::prefix('profile')->group(function () {
//        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
//        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
//        Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
//        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
//        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
//    });
//});


////Работа с корзиной
//Route::prefix('cart')->group(function () {
//    Route::get('/', [CartController::class, 'index'])->name('cart.index');
//    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
//    Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
//    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
//    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
//    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
//    Route::post('/order', [CartController::class, 'storeOrder'])->name('cart.storeOrder')->middleware('auth');
//
//});



