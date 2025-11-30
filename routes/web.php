<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminCustomOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'aboutUs']);
Route::get('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('employees', AdminEmployeeController::class);
    Route::resource('promos', AdminPromoController::class);
    Route::resource('locations', AdminLocationController::class);
    Route::resource('custom-orders', AdminCustomOrderController::class);
});

require __DIR__.'/auth.php';




























// Route::get('employees', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'index'])->name('employees.index');
// Route::get('employees/create', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'create'])->name('employees.create');
// Route::post('employees', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'store'])->name('employees.store');
// Route::get('employees/{employee}', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'show'])->name('employees.show');
// Route::get('employees/{employee}/edit', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'edit'])->name('employees.edit');
// Route::match(['put','patch'],'employees/{employee}', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'update'])->name('employees.update');
// Route::delete('employees/{employee}', [\App\Http\Controllers\Admin\AdminEmployeeController::class, 'destroy'])->name('employees.destroy');