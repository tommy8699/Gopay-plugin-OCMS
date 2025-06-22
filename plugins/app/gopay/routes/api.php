<?php

use Illuminate\Support\Facades\Route;
use App\Shop\Controllers\Orders;

Route::prefix('api')->group(function () {
    Route::get('pay/{id}', [Orders::class, 'startPayment']);
    Route::post('payment/callback', [Orders::class, 'handleCallback']);
});
