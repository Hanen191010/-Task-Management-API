<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// مجموعة من مسارات API لمعالجة تسجيل الدخول والخروج
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login'); // مسار لمعالجة تسجيل الدخول 
    Route::post('logout', 'logout'); // مسار لمعالجة الخروج
});

// مسارات API للمهام
Route::apiResource('tasks', TaskController::class); // مسارات API للمهام (index, store, show, update, destroy)
Route::post('tasks/{id}/assign', [TaskController::class, 'assign']); // مسار لتعيين مهمة لمستخدم

// مسارات API للمستخدمين
Route::apiResource('users', UserController::class); // مسارات API للمستخدمين (index, store, show, update, destroy)

