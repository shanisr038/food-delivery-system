<?php

use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\CategoryController;
use App\Http\Controllers\Vendor\MenuController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController as PublicRestaurantController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\StaffMemberController;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('restaurant/{restaurant}', [PublicRestaurantController::class, 'show'])->name('restaurant');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Customer Routes
Route::middleware(['auth'])->prefix('customer')->as('customer.')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/{uuid}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // These MUST be here for Ziggy to find them
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
});

// Vendor
Route::middleware(['auth'])->prefix('vendor')->as('vendor.')->group(function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('staff-members', StaffMemberController::class);
});

// Admin
Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('/restaurants', RestaurantController::class);
});

require __DIR__.'/staff.php'; 
require __DIR__.'/auth.php';