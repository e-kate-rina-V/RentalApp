<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminAdController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Models\Ad;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/user', function () {
    if (auth()->check()) {
        return response()->json(auth()->user());
    } else {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/logout/user', [LoginController::class, 'logout']);

Route::post('ad_register', [AdController::class, 'ad_register'])->name('ads.ad_register');

Route::get('/ads', function () {
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $ads = Ad::where('user_id', $user->id)
        ->with('materials')
        ->paginate(2);

    return response()->json($ads);
});

Route::get('/ads/{id}', [AdController::class, 'show']);

Route::get('/all_ads', [AdController::class, 'index']);

Route::post('/reservation', [ReservationController::class, 'store']);

Route::middleware('auth:api')->post('/generate-report', [ReportController::class, 'generateReport']);

Route::get('/reports/download/{fileName}', [ReportController::class, 'downloadReportFromStorage']);

Route::post('/reviews', [ReviewController::class, 'store']);

// Route::post('/chats', [ChatController::class, 'createChat']);

// Route::middleware('auth:sanctum')->get('/chats/{chatId}/messages', [ChatController::class, 'getMessages']);
// Route::middleware('auth:sanctum')->post('/chats/{chatId}/messages', [ChatController::class, 'sendMessage']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('ads', AdminAdController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::resource('users', AdminUserController::class);
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
