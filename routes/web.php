<?php


Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
})->name('front');

// dibawah ini dibutuhkan akses autitentifikasi
Route::group(['middleware' => 'auth'], function () { 
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/kantor-cabang/{id}/delete', 'KantorCabangController@delete');
	Route::resource('/kantor-cabang', 'KantorCabangController');
});