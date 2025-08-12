<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;


Route::middleware('auth:api')->group(function () {
    Route::post('/create', [PaymentController::class, 'create']);
    Route::patch('{payment}/status', [PaymentController::class, 'updateStatus']);
});
