<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/location')->as('location.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'LocationController@index')->name('index');
    Route::get('/create', 'LocationController@create')->name('create');
    Route::post('/store', 'LocationController@store')->name('store');
    Route::get('/view/{id}', 'LocationController@view')->name('view');
    Route::get('/edit/{location}', 'LocationController@edit')->name('edit');
    Route::post('/update/{location}', 'LocationController@update')->name('update');
    Route::get('/destroy/{location}', 'LocationController@destroy')->name('destroy');
});
