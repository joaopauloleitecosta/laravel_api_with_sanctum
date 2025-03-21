<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function() {
    return ApiResponse::success('API is running');
})->middleware('auth:sanctum');

Route::apiResource('clients', ClientController::class)->middleware('auth:sanctum');
// SANCTUM DON'T CONFIG THIS CORRECT YET
//Route::get('/clients', [ClientController::class, 'index'])->middleware('auth:sanctum','ability:clients:list');
//Route::post('/clients', [ClientController::class, 'store'])->middleware('auth:sanctum');
//Route::get('/clients/{client}', [ClientController::class, 'show'])->middleware('auth:sanctum','ability:clients:detail');
//Route::put('/clients/{client}', [ClientController::class, 'update'])->middleware('auth:sanctum');
//Route::delete('/clients/{client}', [ClientController::class, 'delete'])->middleware('auth:sanctum');

//auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');