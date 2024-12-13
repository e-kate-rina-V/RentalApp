<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminAdController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function () {
    if (auth()->check()) {
        return response()->json(auth()->user());
    } else {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
});

Route::get('/logout/user', [LoginController::class, 'logout']);

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/email/verify-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification email sent']);
})->middleware(['auth:sanctum', 'throttle:6,1']);

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::find($id);

    if (!$user || sha1($user->email) !== $hash) {
        Log::error("Invalid verification link for user ID: {$id}");
        return view('auth.verify');
    }

    $user->markEmailAsVerified();

    return view('auth.verify')->with('status', 'Email has been successfully verified!');
})->middleware('signed')->name('verification.verify');


Route::get('/email/verification-status', function (Request $request) {
    return response()->json(['verified' => $request->user()->hasVerifiedEmail()]);
})->middleware('auth:sanctum');


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

Route::get('/users/{user_id}', [UserController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:renter'])->get('/all_ads', [AdController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:renter'])->post('/reservation', [ReservationController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:renter'])->get('/ads/{ad}/unavailable-dates', [ReservationController::class, 'getUnavailableDates']);

Route::middleware(['auth:sanctum', 'role:renter'])->post('/reviews', [ReviewController::class, 'store']);

Route::get('/ads/{adId}/reviews', [ReviewController::class, 'show']);

Route::middleware('auth:api')->post('/generate-report', [ReportController::class, 'generateReport']);

Route::middleware(['auth:sanctum', 'role:landlord'])->get('/reports/download/{fileName}', [ReportController::class, 'downloadReportFromStorage']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chats/{adId}/start', [ChatController::class, 'startChat']);
    Route::get('/chats', [ChatController::class, 'getUserChats']);

    Route::get('/chats/{chatId}/messages', [MessageController::class, 'getMessages']);
    Route::post('/chats/{chatId}/messages', [MessageController::class, 'sendMessage']);
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('ads', AdminAdController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::resource('users', AdminUserController::class);
});


Auth::routes();

