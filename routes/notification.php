<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/notification')->as('notification.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'NotificationController@index')->name('index');
    Route::get('/create', 'NotificationController@create')->name('create');
    Route::post('/store', 'NotificationController@store')->name('store');
    Route::get('/view/{id}', 'NotificationController@view')->name('view');
    Route::get('/edit/{notification}', 'NotificationController@edit')->name('edit');
    Route::post('/update/{notification}', 'NotificationController@update')->name('update');
    Route::get('/destroy/{notification}', 'NotificationController@destroy')->name('destroy');
});
