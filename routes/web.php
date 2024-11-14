<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CsrfTokenController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Route::get('/users/create', [UserController::class, 'create'])->name('user.create');

Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('csrf-token', [CsrfTokenController::class, 'getToken']);


// Route::get('/palmo', function () {
//     return view('palmo');
// });

# Route::view(uri: 'palmo', view: 'palmo');

# Route::get('/user', [UserController::class, 'getUser']);

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
