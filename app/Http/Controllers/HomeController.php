<?php

namespace App\Http\Controllers;

use App\Cabang;
use App\Perkembangan;
use App\ProgramKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    	$startdate = (empty($request->startdate) ? now()->firstOfMonth() : $request->startdate);
    	$enddate = (empty($request->enddate) ? now() : $request->enddate);

    	$data = Perkembangan::selectRaw('
    		sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp, 
    		sum(sisa_kas) as sum_sisa_kas')
		->where('tanggal','>=',$startdate)
		->where('tanggal','<=',$enddate)
    	->first();
    	// dd($startdate);
    	if($request->ajax())
    	{
    		$labels = [];
    		$chart = Perkembangan::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas,cabang')
    		->where('tanggal','>=',$startdate)
    		->where('tanggal','<=',$enddate)
    		->groupBy('cabang')
    		->get();

    		$dataFilter = Perkembangan::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas')
    		->where('tanggal','>=',$startdate)
    		->where('tanggal','<=',$enddate)
    		->first();
    		// dd($chart->toArray(),$request->startdate, $request->enddate);
    		
    		$labels = $chart->mapWithKeys(function ($item, $key) {
    			return [ucfirst(optional($item->Cabang)->cabang) => ucfirst($item->cabang)];
    		});

    		$globalTable = $chart->mapWithKeys(function ($item, $key) {
    			return [ucfirst(optional($item->Cabang)->cabang) => [
    				'sum_drop' => $item->sum_drop,
    				'sum_psp' => $item->sum_psp,
    				'sum_storting' => $item->sum_storting,
    				'sum_drop_tunda' => $item->sum_drop_tunda,
    				'sum_storting_tunda' => $item->sum_storting_tunda,
    				'sum_tkp' => $item->sum_tkp,
    				'sum_sisa_kas' => $item->sum_sisa_kas,
    			]];
    		});
    		$labels = $labels->keys();

			// $mapDrop = $chart->mapToGroups(function ($item, $key) {
			// 	return [ ucfirst($item->Cabang->cabang)  => $item->sum_drop];
			// });
			// dd($chart->toArray());
			// foreach($chart as $k => $v){
			// 	$chartset[] = $chart
			// }
    		$kategori = [];
    		foreach ($chart as $key => $value) {
    			$kategori['unit'][] = optional($value->Cabang)->cabang;
    			$kategori['drop'][] = $value->sum_drop;
    			$kategori['storting'][]=$value->sum_storting;
    			// $kategori['psp'][]=$value->sum_psp;
    			// $kategori['tkp'][]=$value->sum_tkp;
    			$kategori['drop_tunda'][]=$value->sum_drop_tunda;
    			$kategori['storting_tunda'][]=$value->sum_storting_tunda;
    		}
    		$dataset=[];
    		foreach ($kategori as $key => $value) {
    			if($key != 'unit'){
    				$dataset[] = [ 
    					'label' => $key, 
    					'data' => $value,  
    					'maxBarThickness' => 50,
    				];
    			}
    		}

    		$dataset = json_encode($dataset);
    		$tanggalFilter = 'Periode <b>'. date_format(date_create_from_format('Y-m-d', $startdate), 'd F Y') . '</b> s/d <b>'. date_format(date_create_from_format('Y-m-d', $enddate), 'd F Y') . '</b>';
    		return view('dashboard.chart', compact('labels', 'dataset','kategori','chart','globalTable','dataFilter', 'tanggalFilter'));
		} //tutup ajax
		return view('home', compact('data','startdate','enddate'));
	}

	public function underContraction()
	{
		return view('under_contraction');
	}
}
