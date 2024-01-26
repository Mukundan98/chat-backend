<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
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

Route::post('/register', [UserController::class, 'registerUser']);
Route::put('/update/{userId}', [UserController::class, 'updateUser']);

Route::get('/messages', [ChatController::class, 'getMessages']);
Route::post('/send-message', [ChatController::class, 'sendMessage']);
