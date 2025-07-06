<?php

use Illuminate\Support\Facades\Route;
use App\Gopay\Http\Controllers\OrdersController;
use App\Gopay\Http\Controllers\WebhookController;

// Definovanie rout pre platby a webhooky

Route::prefix('api')->group(function () {
    // Platba začne
    Route::get('pay/{id}', [OrdersController::class, 'startPayment']);

    // Callback notifikácie zo služby GoPay
    Route::post('payment/callback', [WebhookController::class, 'handleWebhook']);
});
