<?php

use App\Http\Controllers\Staff\OrderController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'staff',
    'as'         => 'staff.',
    'middleware' => ['auth'],
], function () {
    // This creates the index, update, and other standard routes
    Route::resource('orders', OrderController::class);
});