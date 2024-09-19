<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/posts', [PostController::class, 'index']);
   Route::post('/posts', [PostController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/categories', [CategoryController::class, 'index']);
   Route::post('/categories', [CategoryController::class, 'store']);
});

Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
