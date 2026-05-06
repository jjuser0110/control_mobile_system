<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/device')->as('device.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'DeviceController@index')->name('index');
    Route::get('/create', 'DeviceController@create')->name('create');
    Route::post('/store', 'DeviceController@store')->name('store');
    Route::get('/app/{id}', 'DeviceController@app')->name('app');
    Route::get('/edit/{device}', 'DeviceController@edit')->name('edit');
    Route::post('/update/{device}', 'DeviceController@update')->name('update');
    Route::get('/destroy/{device}', 'DeviceController@destroy')->name('destroy');
});
