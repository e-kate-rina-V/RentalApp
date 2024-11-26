<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mainpage', function () {
    return view('mainpage');
});


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

Route::post('ad_register', [AdController::class, 'ad_register'])->name('ads.ad_register');

// Route::post('/users/register', [UserController::class, 'register'])->name('user.register');

// Route::post('/users/login', [UserController::class, 'login'])->name('user.login');

# Route::view(uri: 'palmo', view: 'palmo');

# Route::get('/user/{id}/profile/{groupId?}', [UserController::class, 'getUser']);

// Route::get('/user/{id}', function (string $id) {
//     return $id;
// })->where('id', '[0-9]+'); // Значения id от 1 до 9

# Route::get('/user/{id}', [UserController::class, 'getUser'])->name(name: 'get-name'); // Можно писать имя вместо uri

# Група маршрутов

// Route::prefix(prefix: 'tasks')->group(function () {  # префикс tasks для каждого

# 7 базовых маршрутов
# Просмотр всех тасков в системе
//     Route::get('/', [TaskController::class, 'index'])->name(name: 'tasks.index');
# Страница с формой для создания таска
//     Route::get('/create', [TaskController::class, 'create'])->name(name: 'tasks.create');
# Принимает данные с формы, логика для создания таска
//     Route::post('/', [TaskController::class, 'store'])->name(name: 'tasks.store');
# Отвечает за отображение страницы с описанием одного таска
//     Route::get('/{task}', [TaskController::class, 'show'])->name(name: 'tasks.show');
# Возвращает страницу с формой для редактирования таска
//     Route::get('/{task}/edit', [TaskController::class, 'edit'])->name(name: 'tasks.edit');
# Обновляет таск в базе данных
//     Route::put('/{task}', [TaskController::class, 'update'])->name(name: 'tasks.update');
# Отвечает за удаление таска
//     Route::delete('/{task}', [TaskController::class, 'destroy'])->name(name: 'tasks.destroy');
// });

// Route::group([
//     'as' => 'tasks.',
//     'prefix' => 'tasks', // Будет автоматически добавлен 
// ], function () {
//     Route::get('/', [TaskController::class, 'index'])->name(name: 'index');
//     // Route::get('/create', [TaskController::class, 'create'])->name(name: 'create');
//     // Route::post('/', [TaskController::class, 'store'])->name(name: 'store');
//     // Route::get('/{task}', [TaskController::class, 'show'])->name(name: 'show');
//     // Route::get('/{task}/edit', [TaskController::class, 'edit'])->name(name: 'edit');
//     // Route::put('/{task}', [TaskController::class, 'update'])->name(name: 'update');
//     // Route::delete('/{task}', [TaskController::class, 'destroy'])->name(name: 'destroy');
// });

// Route::resource(name: 'tasks', controller: TaskController::class); // Эквивалентная строка 7-ми строкам

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
