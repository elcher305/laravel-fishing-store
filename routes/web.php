<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


// Аутентификация
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Личный кабинет (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/address/add', [DashboardController::class, 'addAddress'])->name('address.add');
    Route::post('/order/create', [DashboardController::class, 'createOrder'])->name('order.create');
    Route::post('/review/create', [DashboardController::class, 'createReview'])->name('review.create');
});


// Каталог товаров
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/category/{slug}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
