<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/ads/ad_register', [AdController::class, 'ad_register']);
// });

Route::middleware('auth')->get('/user', function () {
    return Auth::user();
});


// Route::post('register', [RegisterController::class, 'register']);
// Route::post('login', [LoginController::class, 'login']);
// Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);