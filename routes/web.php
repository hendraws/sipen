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

Route::get('/chart', function(){
	    	// PERBANDINGAN
	$bulanSekarang = Carbon::now()->subMonth(0)->format('m');
	$bulanKemarin = Carbon::now()->subMonth(1)->format('m');
	$jmlHariSekarang = Carbon::now()->subMonth(0)->endOfMonth()->format('d');
	$jmlHariKemarin = Carbon::now()->subMonth(1)->endOfMonth()->format('d');
	$labels = [];

	$perbandingan = Perkembangan::selectRaw('
		sum(drops) as sum_drop, 
		sum(psp) as sum_psp,
		sum(storting) as sum_storting,
		sum(drop_tunda) as sum_drop_tunda, 
		sum(storting_tunda) as sum_storting_tunda, 
		sum(tkp) as sum_tkp, 
		sum(sisa_kas) as sum_sisa_kas, 
		tanggal, 
		MONTH(tanggal) as bulan, 
		DAY(tanggal) as hari')
	->whereIn(DB::raw('MONTH(tanggal)'),[$bulanKemarin,$bulanSekarang])
	->whereYear('tanggal', date('Y'))
	->groupBy('tanggal')
	->get();

	$labels = $perbandingan->mapWithKeys(function ($item, $key) {
		return ['hari ke ' . $item->hari => $item->sum_drop];
	});
	$perbandinganLabels = $labels->keys();
	$mapDrop = $perbandingan->mapToGroups(function ($item, $key){
		$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
		return [ $bulan  => $item->sum_drop];
	});
	
	foreach($mapDrop as $k => $v){
		$cum = 0;
		foreach($v as $val){
			$mapping[$k][] = $cum +=$val;
		} 
	}

	foreach ($mapping as $key => $value) {
		$drops[] = [ 
			'label' => $key , 
			'data' => $value, 
		];
	}

	$perbandinganDrop = json_encode($drops);
	return view('backend.perkembangan.global.perbandingan2',compact('perbandinganLabels','perbandinganDrop'));
});
// dibawah ini dibutuhkan akses autitentifikasi
Route::group(['middleware' => 'auth'], function () { 
	Route::get('/home', 'HomeController@index')->name('home');
	// Route::get('/report/{id}/delete', 'ReportController@delete');
	// Route::resource('/report', 'ReportController');
	Route::get('/program-kerja/{id}/delete', 'ProgramKerjaController@delete');
	Route::get('/program-kerja/print', 'ProgramKerjaController@print');
	Route::resource('/program-kerja', 'ProgramKerjaController');
	Route::get('/kantor-cabang/{id}/delete', 'KantorCabangController@delete');
	Route::get('/kantor-cabang/print', 'KantorCabangController@print');
	Route::resource('/kantor-cabang', 'KantorCabangController');


	Route::match(['get','post'],'/perkembangan', 'ReportController@perkembangan');
	Route::match(['get','post'],'/perkembangan-global', 'PerkembanganController@global');
	Route::match(['get','post'],'/perkembangan-cabang', 'PerkembanganController@cabang');
	Route::get('/perkembangan-data/print', 'PerkembanganController@printHarian');
	Route::get('/perkembangan-data/cetak', 'PerkembanganController@cetak');
	Route::resource('/perkembangan-data', 'PerkembanganController');
	Route::get('/under-contraction', 'HomeController@underContraction');
	Route::get('/management-user/{id}/delete', 'UserController@delete');
	Route::resource('/management-user', 'UserController');
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
					$drop = rand(10000000,25000000);
					$storting = $drop * 5;
					$psp = $drop*0.05;
					$drop_tunda = rand(10000,750000);
					$storting_tunda = $drop_tunda * 0.1;
					$tkp = $storting - ($drop / 100 * 91) - $psp;
					$sisa_kas = rand(1000000,25000000);
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