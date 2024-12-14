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

Route::get('/home', function () {
    return view('mainpage');
})->name('home');

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('email')->group(function () {
    Route::post('/verify-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent']);
    })->middleware(['auth:sanctum', 'throttle:6,1']);

    Route::get('/verify/{id}/{hash}', function (Request $request, $id, $hash) {
        $user = User::find($id);

        if (!$user || sha1($user->email) !== $hash) {
            Log::error("Invalid verification link for user ID: {$id}");
            return view('auth.verify');
        }

        $user->markEmailAsVerified();

        return view('auth.verify')->with('status', 'Email has been successfully verified!');
    })->middleware('signed')->name('verification.verify');


    Route::get('/verification-status', function (Request $request) {
        return response()->json(['verified' => $request->user()->hasVerifiedEmail()]);
    })->middleware('auth:sanctum');
});


Route::prefix('ads')->group(function () {
    Route::post('register', [AdController::class, 'registerAd']);

    Route::get('/', [AdController::class, 'showUserAds']);

    Route::get('/{id}', [AdController::class, 'showAdById']);

    Route::get('/{ad}/unavailable-dates', [ReservationController::class, 'getUnavailableDates']);

    Route::get('/{adId}/reviews', [ReviewController::class, 'showReviews']);
});

Route::middleware(['auth:sanctum', 'role:renter'])->get('all_ads', [AdController::class, 'showAllAds']);

Route::middleware(['auth:sanctum', 'role:renter'])->post('/reservation', [ReservationController::class, 'createReservation']);

Route::middleware(['auth:sanctum', 'role:renter'])->post('/reviews', [ReviewController::class, 'createReview']);


Route::middleware('auth:sanctum')->prefix('chats')->group(function () {
    Route::post('/{adId}/start', [ChatController::class, 'startChat']);
    Route::get('/', [ChatController::class, 'getUserChats']);

    Route::get('/{chatId}/messages', [MessageController::class, 'getMessages']);
    Route::post('/{chatId}/messages', [MessageController::class, 'sendMessage']);
});


Route::get('/users/{user_id}', [UserController::class, 'showUser']);

Route::middleware('auth:api')->post('/generate-report', [ReportController::class, 'generateReport']);

Route::middleware(['auth:sanctum', 'role:landlord'])->get('/reports/download/{fileName}', [ReportController::class, 'downloadReportFromStorage']);


Route::get('login/admin', function () {
    return view('auth.login');
})->name('login.admin');;

Route::prefix('admin')->group(function () {
    Route::post('login', [LoginController::class, 'loginAdmin'])->name('admin.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('ads', AdminAdController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::resource('users', AdminUserController::class);
});


Auth::routes();
