<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminAdController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::middleware('auth:sanctum')->get('/user', 'getUser');
    Route::get('/home', 'home')->name('home');
    Route::get('login/admin', 'adminLogin')->name('login.admin');
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
});

Route::get('logout', [LoginController::class, 'logout']);

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('ads')->group(function () {
    Route::controller(AdController::class)->group(function () {
        Route::middleware(['role:landlord'])->group(function () {
            Route::post('register', 'registerAd');
            Route::get('/', 'showUserAds');
        });
        Route::middleware(['role:landlord|renter'])->group(function () {
            Route::get('/{id}', 'showAdById');
            Route::get('/{ad}/unavailable-dates', 'getUnavailableDates');
        });
    });
    Route::middleware(['role:landlord|renter'])->get('/{adId}/reviews', [ReviewController::class, 'showReviews']);
});

Route::middleware(['role:renter'])->group(function () {
    Route::get('all_ads', [AdController::class, 'showAllAds']);
    Route::post('reservation', [ReservationController::class, 'createReservation']);
    Route::post('reviews', [ReviewController::class, 'createReview']);
});

Route::middleware(['role:landlord|renter'])->group(function () {
    Route::controller(ChatController::class)->group(function () {
        Route::middleware('auth:sanctum')->prefix('chats')->group(function () {
            Route::post('/{adId}/start', 'startChat');
            Route::get('/', 'getUserChats');
        });
    });
    Route::controller(MessageController::class)->group(function () {
        Route::middleware('auth:sanctum')->prefix('chats/{chatId}/messages')->group(function () {
            Route::get('/', 'getMessages');
            Route::post('/', 'sendMessage');
        });
    });
});

Route::get('/users/{user_id}', [UserController::class, 'showUser']);

Route::middleware(['role:landlord'])->controller(ReportController::class)->group(function () {
    Route::middleware('auth:api')->post('/generate-report', 'generateReport');
    Route::middleware(['auth:sanctum', 'role:landlord'])->get('/reports/download/{fileName}', 'downloadReportFromStorage');
});

Route::controller(LoginController::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('login', 'loginAdmin')->name('admin.login');
        Route::post('logout', 'logout')->name('admin.logout');
    });
});

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::resource('ads', AdminAdController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::resource('users', AdminUserController::class);
});


Route::prefix('email')->group(function () {
    Route::post('/verify-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent']);
    })->middleware(['auth:sanctum', 'throttle:6,1']);

    Route::get('/verify/{id}/{hash}', function ($id, $hash) {
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

Auth::routes();
