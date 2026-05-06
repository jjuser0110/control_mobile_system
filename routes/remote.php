<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/remote')->as('remote.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'RemoteController@index')->name('index');
    Route::get('/create', 'RemoteController@create')->name('create');
    Route::post('/store', 'RemoteController@store')->name('store');
    Route::get('/view/{id}', 'RemoteController@view')->name('view');
    Route::get('/edit/{remote}', 'RemoteController@edit')->name('edit');
    Route::post('/update/{remote}', 'RemoteController@update')->name('update');
    Route::get('/destroy/{remote}', 'RemoteController@destroy')->name('destroy');
});
