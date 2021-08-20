<?php

use App\KantorCabang;
use App\ProgramKerja;
use Illuminate\Support\Carbon;



Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
})->name('front');

// dibawah ini dibutuhkan akses autitentifikasi
Route::group(['middleware' => 'auth'], function () { 
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/report/{id}/delete', 'ReportController@delete');
	Route::resource('/report', 'ReportController');
	Route::get('/program-kerja/{id}/delete', 'ProgramKerjaController@delete');
	Route::resource('/program-kerja', 'ProgramKerjaController');
	Route::get('/kantor-cabang/{id}/delete', 'KantorCabangController@delete');
	Route::resource('/kantor-cabang', 'KantorCabangController');

	// coming soon
	Route::match(['get','post'],'/perkembangan', 'ReportController@perkembangan');
	// Route::match(['get','post'],'/perkembangan', 'ReportController@perbandinganGlobal');
	Route::get('/data-pengguna', 'HomeController@underContraction');

	// command
	Route::get('/command/artisan/migrate', function(){
		Artisan::call('migrate');
		return 'Migrated';
	});

	Route::get('/command/artisan/clear-cache', function(){
		Artisan::call('cache:clear');
		Artisan::call('config:clear');
		Artisan::call('view:clear');

		return 'Clear Cache';
	});

	Route::get('/command/artisan/generate/{jml}', function($jml){
		// Laravel Carbon subtract days from current date
		// $date = Carbon::now()->subDays(0);
		
		$jumlah = $jml;

		for ($i=0; $i < $jumlah ; $i++) { 
			$tanggal = Carbon::now()->subDays($i);
			$cabang = KantorCabang::get();
			foreach ($cabang as $value) {
				$cabang = $value->id;
				$drop = rand(10000,100000);
				$storting = rand(100000,500000);
				$psp = rand(5000,50000);
				$drop_tunda = rand(1000,75000);
				$storting_tunda = rand(1000,75000);
				$tkp = $storting - ($drop / 100 * 91) - $psp;
				$sisa_kas = rand(1000,250000);
				ProgramKerja::Create(
    			[
    				"cabang" => $cabang,
    				"tanggal" => $tanggal,
    				"drops" => $drop,
    				"storting" => $storting,
    				"psp" => $psp,
    				"drop_tunda" => $drop_tunda,
    				"storting_tunda" => $storting_tunda,
    				"tkp" => $tkp,
    				"sisa_kas" => $sisa_kas,
    				'created_by' => auth()->user()->id,
    				'updated_by' => auth()->user()->id,
    			]
    		);
			}
		}


		return 'berhasil generate';
	});
});