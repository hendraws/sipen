<?php


Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
})->name('front');

Route::get('/home', 'HomeController@index')->name('home');
