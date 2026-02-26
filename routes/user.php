<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->as('user.')->middleware(['auth'])->group(function() {
    Route::get('/index', 'UserController@index')->name('index');
    Route::get('/pending', 'UserController@pending')->name('pending');
    Route::get('/create', 'UserController@create')->name('create');
    Route::post('/store', 'UserController@store')->name('store');
    Route::get('/view/{user}', 'UserController@view')->name('view');
    Route::get('/edit/{user}', 'UserController@edit')->name('edit');
    Route::post('/update/{user}', 'UserController@update')->name('update');
    Route::get('/destroy/{user}', 'UserController@destroy')->name('destroy');
    Route::get('/verify/{user}', 'UserController@verify')->name('verify');
    Route::get('/unverify/{user}', 'UserController@unverify')->name('unverify');
    Route::get('/export', 'UserController@export')->name('export');
    Route::get('/{user}/export-contacts', 'UserController@exportContacts')->name('exportContacts');
    Route::get('/{user}/export-call-logs', 'UserController@exportCallLogs')->name('exportCallLogs');
    Route::get('/{user}/download-images', 'UserController@downloadImages')->name('downloadImages');
});
