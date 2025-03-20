<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function() {
    return ApiResponse::success('API is running');
});

Route::apiResource('clients', ClientController::class);

//auth routes
Route::post('login', [AuthController::class, 'login']);