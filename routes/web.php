<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Order routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/api/calculate-shipping', [OrderController::class, 'calculateShipping'])->name('api.calculate-shipping');
Route::get('/orders/success/{orderNumber}', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');

// Payment routes
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// QR Code generation route - menggunakan query parameter untuk data yang panjang
Route::get('/qrcode', [QrCodeController::class, 'generate'])->name('qrcode.generate');

// User transaction history
Route::middleware('auth')->group(function () {
    Route::get('/orders-history', [OrderController::class, 'history'])->name('orders.history');
    Route::post('/orders/{orderNumber}/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
});

// Forecasting routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting.index');
    Route::get('/forecasting/{id}', [ForecastingController::class, 'show'])->name('forecasting.show');
});

// User Dashboard routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});

// Karyawan Dashboard routes
Route::middleware(['auth', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{orderNumber}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{orderNumber}/process', [AdminOrderController::class, 'processOrder'])->name('orders.process');
    Route::post('/orders/{orderNumber}/ship', [AdminOrderController::class, 'shipOrder'])->name('orders.ship');
});

// Admin routes (Super Admin only)
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('users', AdminUserController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{orderNumber}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{orderNumber}/process', [AdminOrderController::class, 'processOrder'])->name('orders.process');
    Route::post('/orders/{orderNumber}/ship', [AdminOrderController::class, 'shipOrder'])->name('orders.ship');
});
