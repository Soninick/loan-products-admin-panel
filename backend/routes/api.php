<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    Route::get('products', [ProductController::class, 'index'])->middleware('role:Admin,Viewer');
    Route::post('products', [ProductController::class, 'store'])->middleware('role:Admin');
    Route::put('products/{id}', [ProductController::class, 'update'])->middleware('role:Admin');

    Route::get('users', [UserController::class, 'index'])->middleware('role:Admin,Viewer');
    Route::post('users', [UserController::class, 'store'])->middleware('role:Admin');
    Route::get('users/{id}/eligible-products', [UserController::class, 'eligibleProducts'])->middleware('role:Admin,Viewer');
});
