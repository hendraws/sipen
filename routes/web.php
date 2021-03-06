<?php

use App\AngsuranCalonMacet;
use App\AngsuranKemacetan;
use App\CalonMacet;
use App\KantorCabang;
use App\Kemacetan;
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
	Route::get('/set-hk', 'PerkembanganController@setHk');
	Route::post('/store-hk', 'PerkembanganController@storeHk');

	Route::match(['get','post'],'/perkembangan-global', 'PerkembanganController@global');
	Route::match(['get','post'],'/perkembangan-cabang', 'PerkembanganController@cabang');
	Route::get('/perkembangan-data/print', 'PerkembanganController@printHarian');
	Route::get('/perkembangan-data/cetak', 'PerkembanganController@cetak');
	Route::resource('/perkembangan-data', 'PerkembanganController');
	Route::get('/under-contraction', 'HomeController@underContraction');
	Route::get('/management-user/{id}/delete', 'UserController@delete');
	Route::resource('/management-user', 'UserController');
	
	Route::resource('/target', 'TargetController');
	Route::get('/target/{target}/delete/', 'TargetController@delete');
	Route::post('/target/simpan-hk', 'TargetController@storeHk');
	Route::post('/target/cetak', 'TargetController@cetak');
	Route::get('/target-all', 'TargetController@index2');
	// ----------------------------------------------------------------------------------------- //
	Route::resource('/resort', 'ResortController');
	Route::get('/resort/{resort}/delete/', 'ResortController@delete');

	Route::get('/kemacetan/{kemacetan}/delete', 'KemacetanController@delete');
	Route::resource('/kemacetan', 'KemacetanController');

	Route::get('/calon-macet/{calon_macet}/delete', 'CalonMacetController@delete');
	Route::resource('/calon-macet', 'CalonMacetController');
	
	Route::resource('/pasaran', 'PasaranController');

	Route::resource('/anggota-lalu', 'AnggotaLaluController');
	Route::get('/anggota-lalu/{anggotaLalu}/delete', 'AnggotaLaluController@delete');
	
	Route::resource('/angsuran-kemacetan', 'AngsuranKemacetanController');
	Route::resource('/angsuran-calon-macet', 'AngsuranCalonMacetController');

	Route::resource('/Target-lalu', 'TargetLaluController');
	Route::get('sirkulasi-perkembangan', 'TargetController@report');
	// Route::get('report/sirkulasi-perkembangan', 'PerkembanganController@')

	Route::get('sinkronisasi-kemacetan', function(){
		$kemacetan = Kemacetan::get();

		foreach ($kemacetan as $data) {
			# code...
			$dataAngsuran = AngsuranKemacetan::where('cabang_id', $data->cabang_id)
	    		->where('resort_id', $data->resort_id)
	    		->where('pasaran', $data->pasaran)
	    		->where('kemacetan_id', $data->id)
	    		->selectRaw('sum(angsuran) as totalAngsuran')
	    		// ->groupBy('kemacetan_id')
	    		->first();
	    	// dd($dataAngsuran);
	    	if(!empty($dataAngsuran)){
		    	$data->update([
	    			'sisa_angsuran' => $data->total_saldo - $dataAngsuran->totalAngsuran
	    		]);
	    	}else{
	    		$data->update([
	    			'sisa_angsuran' => $data->total_saldo - 0
	    		]);
	    	}
		}
	});

	Route::get('sinkronisasi-calon-macet', function(){
		$calonMacet = CalonMacet::get();

		foreach ($calonMacet as $data) {
			# code...
			$dataAngsuran = AngsuranCalonMacet::where('cabang_id', $data->cabang_id)
	    		->where('resort_id', $data->resort_id)
	    		->where('pasaran', $data->pasaran)
	    		->where('calon_macet_id', $data->id)
	    		->selectRaw('sum(angsuran) as totalAngsuran')
	    		->first();

	    		if(!empty($dataAngsuran)){
		    	$data->update([
	    			'sisa_angsuran' => $data->total_saldo - $dataAngsuran->totalAngsuran
	    		]);
	    	}else{
	    		$data->update([
	    			'sisa_angsuran' => $data->total_saldo - 0
	    		]);
	    	}
		}
	});
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