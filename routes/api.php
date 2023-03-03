<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TechnicianPageController;
use App\Http\Controllers\FCMTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/test', [AuthController::class, 'test']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/current_order', [TechnicianPageController::class, 'getCurrenOrder'])->middleware('auth:api');
Route::post('/current_order/accept', [TechnicianPageController::class, 'accept'])->middleware('auth:api');
Route::post('/current_order/complete', [TechnicianPageController::class, 'complete'])->middleware('auth:api');

Route::post('/fcm_token', [FCMTokenController::class, 'store'])->middleware('auth:api');

// Route::middleware('auth:api')->post('/auth/login', function (Request $request) {
//     return $request->user();
// });
