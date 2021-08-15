<?php


Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
})->name('front');

// dibawah ini dibutuhkan akses autitentifikasi
Route::group(['middleware' => 'auth'], function () { 
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/report/{id}/delete', 'ReportController@delete');
	Route::resource('/report', 'ReportController');
	Route::get('/kantor-cabang/{id}/delete', 'KantorCabangController@delete');
	Route::resource('/kantor-cabang', 'KantorCabangController');

	// coming soon
	Route::get('/perkembangan', 'HomeController@underContraction');
	Route::get('/program-kerja', 'HomeController@underContraction');
	Route::get('/data-pengguna', 'HomeController@underContraction');
});