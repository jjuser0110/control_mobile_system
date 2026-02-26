<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/user_otp')->as('user_otp.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'UserOtpController@index')->name('index');
    Route::get('/create', 'UserOtpController@create')->name('create');
    Route::post('/store', 'UserOtpController@store')->name('store');
    Route::get('/edit/{user_otp}', 'UserOtpController@edit')->name('edit');
    Route::post('/update/{user_otp}', 'UserOtpController@update')->name('update');
    Route::get('/destroy/{user_otp}', 'UserOtpController@destroy')->name('destroy');
});
