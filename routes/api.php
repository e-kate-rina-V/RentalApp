<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/user', function () {
    return Auth::user();
});
