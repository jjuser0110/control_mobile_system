<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/network')->as('network.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'NetworkController@index')->name('index');
    Route::get('/create', 'NetworkController@create')->name('create');
    Route::post('/store', 'NetworkController@store')->name('store');
    Route::get('/view/{id}', 'NetworkController@view')->name('view');
    Route::get('/edit/{network}', 'NetworkController@edit')->name('edit');
    Route::post('/update/{network}', 'NetworkController@update')->name('update');
    Route::get('/destroy/{network}', 'NetworkController@destroy')->name('destroy');
});
