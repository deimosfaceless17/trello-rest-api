<?php

use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group(
    ['middleware' => 'api', 'prefix' => 'auth'], function($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::group(
    ['middleware' => 'api', 'prefix' => 'board'], function($router) {
    Route::get('/', [BoardController::class, 'index']);
    Route::post('/', [BoardController::class, 'create']);
    Route::patch('/{id}', [BoardController::class, 'update'])->where('id', '[0-9]+');
});