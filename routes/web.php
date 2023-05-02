<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\LifeController;
use App\Http\Controllers\MathController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\todoController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 管理者
Route::get('/admin', [UserController::class, 'index'])->name('admin');

// エンドユーザー
Route::get('/user', function () {
    return Inertia::render('EndUser');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// 学習アプリ
Route::get('/math',[StudentController::class, 'index']);
Route::post('/math/student-create',[StudentController::class, 'create']);
Route::delete('/math/student-delete/{id}',[StudentController::class, 'delete']);
Route::get('/math/student/{id}',[StudentController::class, 'show']);
Route::post('/math/student/score',[StudentController::class, 'score']);
Route::get('/math/edit',[MathController::class, 'edit']);
Route::get('/math/update/{id}',[MathController::class, 'update']);
Route::post('/math/update/title/{id}',[MathController::class, 'updateTitle']);
Route::post('/math/update/question/{id}',[MathController::class, 'updateQuestion']);
Route::post('/math/update/answer/{id}',[MathController::class, 'updateAnswer']);
Route::post('/math/delete/img/{id}',[MathController::class, 'delImg']);
Route::post('/math/upload/{id}',[MathController::class, 'upload']);
Route::post('/math/question-create',[MathController::class, 'create']);
Route::delete('/math/question-delete/{id}',[MathController::class, 'delete']);

// 人生劇場アプリ
Route::get('/life',[LifeController::class, 'index']);

// お天気アプリ
// Route::get('/sky',[WeatherController::class, 'index'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('/sky',[WeatherController::class, 'index']);

// 掲示板アプリ
Route::get('board', [BoardController::class, 'index'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('/save-data',[BoardController::class, 'saveData'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::delete('/delete-data/{id}',[BoardController::class, 'deleteData'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::put('board/{id}', [BoardController::class, 'update'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('/like/{id}', [BoardController::class, 'like'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);

// todoアプリ
Route::get('todo/', [todoController::class, 'index'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',)->name('index');
Route::post('todo/store', [todoController::class, 'store'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('todo/finish', [todoController::class, 'finish'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/edit/{id}', [todoController::class, 'edit'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('todo/delete', [todoController::class, 'delete'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('todo/update', [todoController::class, 'update'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/show', [todoController::class, 'show'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('todo/upload', [todoController::class, 'upload'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::post('todo/start', [todoController::class, 'start'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);


Route::get('todo/store', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/finish', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/delete', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/update', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/upload', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);
Route::get('todo/start', [todoController::class, 'error'])->middleware('auth:sanctum', config('jetstream.auth_session'), 'verified',);

// Route::get('todo/', [todoController::class, 'home'])->middleware('auth');
// Route::get('todos/', [todoController::class, 'index'])->middleware('auth')->name('index');
// Route::post('todo/store', [todoController::class, 'store'])->middleware('auth');
// Route::post('todo/finish', [todoController::class, 'finish'])->middleware('auth');
// Route::get('todo/edit/{id}', [todoController::class, 'edit'])->middleware('auth');
// Route::post('todo/update', [todoController::class, 'update'])->middleware('auth');
// Route::post('todo/delete', [todoController::class, 'delete'])->middleware('auth');
// Route::post('todo/upload', [todoController::class, 'upload'])->middleware('auth');
// Route::get('todo/show/', [todoController::class, 'show'])->middleware('auth');

// Route::get('todo/store', [todoController::class, 'error'])->middleware('auth');
// Route::get('todo/finish', [todoController::class, 'error'])->middleware('auth');
// Route::get('todo/update', [todoController::class, 'error'])->middleware('auth');
// Route::get('todo/delete', [todoController::class, 'error'])->middleware('auth');