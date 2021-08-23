<?php

use App\KantorCabang;
use App\Perkembangan;
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
	Route::match(['get','post'],'/perkembangan-global', 'PerkembanganController@global');
	Route::resource('/perkembangan-data', 'PerkembanganController');
	// Route::match(['get','post'],'/perkembangan', 'ReportController@perbandinganGlobal');
	// Route::get('/data-pengguna', 'HomeController@underContraction');
	Route::get('/under-contraction', 'HomeController@underContraction');

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
			
		Route::get('/generate/program-kerja/{jml}', function($jml){
		// Laravel Carbon subtract days from current date
		// $date = Carbon::now()->subDays(0);
			$jumlah = $jml;
			for ($i=0; $i < $jumlah ; $i++) { 
				$bulan = Carbon::now()->subMonth($i);
				$cabang = KantorCabang::get();
				foreach ($cabang as $value) {
					$cabang = $value->id;
					$drop = rand(10000000,20000000);
					$storting = rand(8000000,15000000);
					$psp = rand(8000000,15000000);
					$drop_tunda = rand(4000000,10000000);
					$storting_tunda = rand(5000000,10000000);
					$tkp = $storting - ($drop / 100 * 91) - $psp;
					$sisa_kas = rand(8000000,15000000);
					ProgramKerja::Create(
						[
							"cabang" => $cabang,
							"tanggal" => $bulan,
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

		Route::get('/generate/perkembangan/{jml}', function($jml){
		// Laravel Carbon subtract days from current date
		// $date = Carbon::now()->subDays(0);
			$jumlah = $jml;
			for ($i=0; $i < $jumlah ; $i++) { 
				$tanggal = Carbon::now()->subDays($i);
				$cabang = KantorCabang::get();
				foreach ($cabang as $value) {
					$cabang = $value->id;
					$drop = rand(1000000,2500000);
					$storting = $drop * 1.2;
					$psp = $drop*0.05;
					$drop_tunda = rand(1000,75000);
					$storting_tunda = $drop_tunda * 0.1;
					$tkp = $storting - ($drop / 100 * 91) - $psp;
					$sisa_kas = rand(100000,2500000);
					Perkembangan::Create(
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
	
});