<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'Register']);
Route::post('login', [AuthController::class, 'Login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'signOut']);
    Route::get('authenticated', [AuthController::class, 'Authenticated']);
    Route::apiResource('article', ArticleController::class);
    Route::apiResource('comment', CommentController::class);
});

// Route::middleware('auth:sanctum',)->group(function () {
// });
