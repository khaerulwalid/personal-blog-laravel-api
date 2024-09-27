<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use \Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/all', [CategoryController::class, 'getAll']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('/users/all', [UserController::class, 'getAllUsers']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/all', [PostController::class, 'getAllPosts']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});

//Route::middleware(['auth:sanctum'])->post('/email/verification-notification', function (Request $request) {
//    if($request->user()->hasVerifiedEmail())
//    {
//        return response()->json(['message' => 'Email already verified'], 400);
//    }
//
//    $request->user()->sendEmailVerificationNotification();
//
//    return response()->json(['message' => 'Email verification link sent on your email'], 200);
//})->name('verification.send');

//Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//    $request->fulfill();
//
//    return response()->json(['message' => 'Email verified successfully'], 200);
//})->middleware(['auth:sanctum'])->name('verification.verify');
//
//Route::middleware(['auth:sanctum'])->get('/email/check-verification-status', function (Request $request) {
//    return response()->json(['verified' => $request->user()->hasVerifiedEmail()]);
//});

Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
