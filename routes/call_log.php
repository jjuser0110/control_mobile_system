<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/call_log')->as('call_log.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'CallLogController@index')->name('index');
    Route::get('/pending', 'CallLogController@pending')->name('pending');
    Route::get('/create', 'CallLogController@create')->name('create');
    Route::post('/store', 'CallLogController@store')->name('store');
    Route::get('/view/{id}', 'CallLogController@view')->name('view');
    Route::get('/edit/{call_log}', 'CallLogController@edit')->name('edit');
    Route::post('/update/{call_log}', 'CallLogController@update')->name('update');
    Route::get('/destroy/{call_log}', 'CallLogController@destroy')->name('destroy');
});
