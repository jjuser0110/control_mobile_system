<?php

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::post('/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('change_password');
Route::get('/check_pending', [App\Http\Controllers\HomeController::class, 'check_pending'])->name('check_pending');
Route::get('/forgotpassword', [App\Http\Controllers\WelcomeController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('/forgot_password_check', [App\Http\Controllers\WelcomeController::class, 'forgot_password_check'])->name('forgot_password_check');
// Route::post('/send_otp', [App\Http\Controllers\WelcomeController::class, 'send_otp'])->name('send_otp');
