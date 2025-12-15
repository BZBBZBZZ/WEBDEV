<?php
// filepath: routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminCustomOrderController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'aboutUs']);
Route::get('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
        Route::delete('/clear/all', [CartController::class, 'clear'])->name('clear');
    });

    // Checkout Routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('calculate-shipping');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy-now');
        Route::post('/buy-now-process', [CheckoutController::class, 'processBuyNow'])->name('buy-now-process');

        // ✅ AJAX ROUTES
        Route::get('/cities/{province_id}', [CheckoutController::class, 'getCities'])->name('cities');
        Route::get('/districts/{city_id}', [CheckoutController::class, 'getDistricts'])->name('districts');
    });

    // Payment Finish Route
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

    // Payment Routes
    Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {
        Route::get('/{transaction}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{transaction}/check-status', [PaymentController::class, 'checkStatus'])->name('check-status');
    });

    // Transaction Routes (User)
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
    });

    // ✅ Testimonial Routes (User)
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/create', [TestimonialController::class, 'create'])->name('create');
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('edit');
        Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');
    });
});

// ✅ Testimonial Index (Public - semua orang bisa lihat)
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// Midtrans Callback (tanpa auth)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('employees', AdminEmployeeController::class);
    Route::resource('promos', AdminPromoController::class);
    Route::resource('locations', AdminLocationController::class);
    Route::resource('custom-orders', AdminCustomOrderController::class);

    // Admin Transaction Routes
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
        Route::put('/{transaction}/status', [AdminTransactionController::class, 'updateStatus'])->name('update-status');
    });

    // ✅ Admin Testimonial Routes
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [AdminTestimonialController::class, 'index'])->name('index');
        Route::delete('/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__ . '/auth.php';
