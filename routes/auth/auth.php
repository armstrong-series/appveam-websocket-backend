<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::post('/login', [AuthController::class, 'signIn']);
Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);