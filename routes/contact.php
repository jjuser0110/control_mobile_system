<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/contact')->as('contact.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'ContactController@index')->name('index');
    Route::get('/pending', 'ContactController@pending')->name('pending');
    Route::get('/create', 'ContactController@create')->name('create');
    Route::post('/store', 'ContactController@store')->name('store');
    Route::get('/view/{id}', 'ContactController@view')->name('view');
    Route::get('/edit/{contact}', 'ContactController@edit')->name('edit');
    Route::post('/update/{contact}', 'ContactController@update')->name('update');
    Route::get('/destroy/{contact}', 'ContactController@destroy')->name('destroy');
});
