<?php

namespace App\Http\Controllers;

use App\KantorCabang;
use App\ProgramKerja;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
	public function perkembangan(Request $request)
	{
		$bulanSekarang = Carbon::now()->subMonth(0)->format('m');
		$bulanKemarin = Carbon::now()->subMonth(1)->format('m');
		$jmlHariSekarang = Carbon::now()->subMonth(0)->endOfMonth()->format('d');
		$jmlHariKemarin = Carbon::now()->subMonth(1)->endOfMonth()->format('d');
		if($jmlHariKemarin >= $jmlHariSekarang )
		{
			$maxHari = $jmlHariKemarin; 
		}else{
			$maxHari = $jmlHariSekarang; 
		}

		if($request->ajax())
		{
			$labels = [];
			$data = ProgramKerja::selectRaw('
				sum(drops) as sum_drop, 
				sum(psp) as sum_psp,
				sum(storting) as sum_storting,
				sum(drop_tunda) as sum_drop_tunda, 
				sum(storting_tunda) as sum_storting_tunda, 
				sum(tkp) as sum_tkp, 
				sum(sisa_kas) as sum_sisa_kas, 
				tanggal, 
				MONTH(tanggal) as bulan, 
				DAY(tanggal) as hari  ')
			->whereIn(DB::raw('MONTH(tanggal)'),[$bulanKemarin,$bulanSekarang])
			->whereYear('tanggal', date('Y'))
			->groupBy('tanggal')
			->get();

			$labels = $data->mapWithKeys(function ($item, $key) {
				return ['hari ke ' . $item->hari => $item->sum_drop];
			});
			$labels = $labels->keys();

			if($request->graphic == 'dropChart'){ 
				
				$mapDrop = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_drop];
				});

				foreach ($mapDrop as $key => $value) {
					$drops[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}

				$data = json_encode($drops);
				return view('backend.perkembangan.drop', compact('labels', 'data'));
			}

			if($request->graphic == 'stortingChart'){ 

				$mapStorting = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_storting];
				});

				foreach ($mapStorting as $key => $value) {
					$storting[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($storting);

				return view('backend.perkembangan.storting', compact('labels', 'data'));
			}			

			if($request->graphic == 'pspChart'){ 

				$mapPsp = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_psp];
				});

				foreach ($mapPsp as $key => $value) {
					$psp[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($psp);

				return view('backend.perkembangan.psp', compact('labels', 'data'));
			}

			if($request->graphic == 'dropTundaChart'){ 

				$mapDropTunda = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_drop_tunda];
				});

				foreach ($mapDropTunda as $key => $value) {
					$dropTunda[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($dropTunda);

				return view('backend.perkembangan.drop_tunda', compact('labels', 'data'));
			}
			
			if($request->graphic == 'stortingTundaChart'){ 

				$mapStortingTunda = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->storting_tunda];
				});

				foreach ($mapStortingTunda as $key => $value) {
					$stortingTunda[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($stortingTunda);

				return view('backend.perkembangan.storting_tunda', compact('labels', 'data'));
			}

			if($request->graphic == 'tkpChart'){ 

				$mapTkp = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_tkp];
				});

				foreach ($mapTkp as $key => $value) {
					$tkp[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($tkp);

				return view('backend.perkembangan.tkp', compact('labels', 'data'));
			}

			if($request->graphic == 'sisaKasChart'){ 

				$mapSisaKas = $data->mapToGroups(function ($item, $key) {
					$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
					return [ $bulan  => $item->sum_sisa_kas];
				});

				foreach ($mapSisaKas as $key => $value) {
					$sisaKas[] = [ 
						'label' => $key , 
						'data' => $value->toArray(), 
					];
				}
				$data = json_encode($sisaKas);

				return view('backend.perkembangan.sisa_kas', compact('labels', 'data'));
			}

		} //tutup ajax

		
		return view('backend.perkembangan.index');
		// return Carbon::now()->subMonth(12)->format('m');
		
	}

	public function perbandinganGlobal(Request $request)
	{
		$bulanSekarang = Carbon::now()->subMonth(0)->format('m');
		$bulanKemarin = Carbon::now()->subMonth(1)->format('m');
		if($request->ajax())
		{
			$labels = [];
			$data = ProgramKerja::selectRaw('
				sum(drops) as sum_drop, 
				sum(psp) as sum_psp,
				sum(storting) as sum_storting,
				sum(drop_tunda) as sum_drop_tunda, 
				sum(storting_tunda) as sum_storting_tunda, 
				sum(tkp) as sum_tkp, 
				sum(sisa_kas) as sum_sisa_kas, 
				tanggal, 
				MONTH(tanggal) as bulan, 
				DAY(tanggal) as hari  ')
			->whereIn(DB::raw('MONTH(tanggal)'),[$bulanKemarin,$bulanSekarang])
			->whereYear('tanggal', date('Y'))
			->groupBy('tanggal')
			->get();

			$labels = $data->mapWithKeys(function ($item, $key) {
				return ['hari ke ' . $item->hari => $item->sum_drop];
			});
			$labels = $labels->keys();

			$mapDrop = $data->mapToGroups(function ($item, $key) {
				$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
				return [ $bulan  => $item->sum_drop];
			});
			
			foreach ($mapDrop as $key => $value) {
				$drops[] = [ 
					'label' => $key , 
					'data' => $value->toArray(), 
				];
			}
			$data = json_encode($drops);

			return view('backend.perkembangan.drop', compact('labels', 'data'));
		} //tutup ajax

		
		return view('backend.perkembangan.index');
		// return Carbon::now()->subMonth(12)->format('m');
		
	}
}
