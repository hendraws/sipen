<?php

use App\KantorCabang;
use App\Perkembangan;
use App\ProgramKerja;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;



Auth::routes();

Route::get('/', function () {
	return redirect(route('login'));
})->name('front');

// dibawah ini dibutuhkan akses autitentifikasi
Route::group(['middleware' => 'auth'], function () { 
	Route::get('/home', 'HomeController@index')->name('home');
	Route::put('/program-kerja/{id}/reset', 'ProgramKerjaController@reset');
	Route::get('/program-kerja/{id}/resetModal', 'ProgramKerjaController@resetModal');
	Route::get('/program-kerja/{id}/delete', 'ProgramKerjaController@delete');
	Route::get('/program-kerja/print', 'ProgramKerjaController@print');
	Route::resource('/program-kerja', 'ProgramKerjaController');
	Route::get('/kantor-cabang/{id}/delete', 'KantorCabangController@delete');
	Route::get('/kantor-cabang/print', 'KantorCabangController@print');
	Route::resource('/kantor-cabang', 'KantorCabangController');

	Route::put('/perkembangan-data/{id}/reset', 'PerkembanganController@reset');
	Route::get('/perkembangan-data/{id}/delete', 'PerkembanganController@delete');
	Route::get('/perkembangan-data/{id}/reset-modal', 'PerkembanganController@resetModal');
	Route::match(['get','post'],'/perkembangan', 'ReportController@perkembangan');

	Route::match(['get','post'],'/perkembangan-global', 'PerkembanganController@global');
	Route::match(['get','post'],'/perkembangan-cabang', 'PerkembanganController@cabang');
	Route::get('/perkembangan-data/print', 'PerkembanganController@printHarian');
	Route::get('/perkembangan-data/cetak', 'PerkembanganController@cetak');
	Route::resource('/perkembangan-data', 'PerkembanganController');
	Route::get('/under-contraction', 'HomeController@underContraction');
	Route::get('/management-user/{id}/delete', 'UserController@delete');
	Route::resource('/management-user', 'UserController');
	
	// ----------------------------------------------------------------------------------------- //
	Route::resource('/resort', 'ResortController');
	Route::get('/resort/{resort}/delete/', 'ResortController@delete');



	// command
	Route::group(['prefix'=>'/command/artisan','as'=>'account.'], function(){ 
		Route::get('/migrate', function(){
			Artisan::call('migrate');
			return 'Migrated';
		});

		Route::get('/clear-cache', function(){
			Artisan::call('optimize:clear');

			return 'Clear Cache';
		});
	});
	
});