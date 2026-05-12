<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/system_info')->as('system_info.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'SystemInfoController@index')->name('index');
    Route::get('/create', 'SystemInfoController@create')->name('create');
    Route::post('/store', 'SystemInfoController@store')->name('store');
    Route::get('/view/{id}', 'SystemInfoController@view')->name('view');
    Route::get('/edit/{system_info}', 'SystemInfoController@edit')->name('edit');
    Route::post('/update/{system_info}', 'SystemInfoController@update')->name('update');
    Route::get('/destroy/{system_info}', 'SystemInfoController@destroy')->name('destroy');
});
