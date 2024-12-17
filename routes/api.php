<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/user', function () {
    return Auth::user();
});
