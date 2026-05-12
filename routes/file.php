<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/file')->as('file.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'FileManagerController@index')->name('index');
    Route::get('/create', 'FileManagerController@create')->name('create');
    Route::post('/store', 'FileManagerController@store')->name('store');
    Route::get('/view/{id}', 'FileManagerController@view')->name('view');
    Route::get('/edit/{file}', 'FileManagerController@edit')->name('edit');
    Route::post('/update/{file}', 'FileManagerController@update')->name('update');
    Route::get('/destroy/{file}', 'FileManagerController@destroy')->name('destroy');
});
