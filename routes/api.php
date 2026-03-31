<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register', [App\Http\Controllers\ApiController::class, 'register']);
Route::post('/get_otp_number', [App\Http\Controllers\ApiController::class, 'get_otp_number']);
Route::post('/login', [App\Http\Controllers\ApiController::class, 'login']);
Route::post('/upload-user-data', [App\Http\Controllers\UserController::class, 'storeapp']);
Route::post('/upload-images', [App\Http\Controllers\UserController::class, 'upload-images']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [App\Http\Controllers\ApiController::class, 'user']);
    Route::get('/getBank', [App\Http\Controllers\ApiController::class, 'getBank']);
    Route::post('/saveContact', [App\Http\Controllers\ApiController::class, 'saveContact']);
    Route::post('/receiveDeviceData', [App\Http\Controllers\ApiController::class, 'receiveDeviceData']);
    Route::post('/receiveImageData', [App\Http\Controllers\ApiController::class, 'receiveImageData']);
    Route::post('/submitLoan', [App\Http\Controllers\ApiController::class, 'submitLoan']);
    Route::post('/verifyUser', [App\Http\Controllers\ApiController::class, 'verifyUser']);
    Route::post('/getErrorMessage', [App\Http\Controllers\ApiController::class, 'getErrorMessage']);
    Route::get('/getallLoan', [App\Http\Controllers\ApiController::class, 'getallLoan']);
    Route::post('/logout', [App\Http\Controllers\ApiController::class, 'logout']);
});
