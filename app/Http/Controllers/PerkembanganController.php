<?php

namespace App\Http\Controllers;

use App\Perkembangan;
use App\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PerkembanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    	if ($request->ajax()) {
    		$data = Perkembangan::where('cabang', auth()->user()->cabang_id)
    		->select('*')
    		->selectRaw('DAY(tanggal) as hari')
    		->whereMonth('tanggal',date('m'))
    		->whereYear('tanggal',date('Y'))
    		->orderBy('tanggal','desc');
    		return Datatables::of($data)
    		// ->addIndexColumn()
    		->addColumn('hari_kerja', function ($row) {
    			$hari = number_format($row->hari);
    			return $hari;
    		})     	
    		->addColumn('drop', function ($row) {
    			$drop = number_format($row->drops);
    			return $drop;
    		})         		
    		->addColumn('storting', function ($row) {
    			$storting = number_format($row->storting);
    			return $storting;
    		})     	
    		->addColumn('tkp', function ($row) {
    			$tkp = number_format($row->tkp);
    			return $tkp;
    		})         		     		
    		->addColumn('drop_tunda', function ($row) {
    			$drop_tunda = number_format($row->drop_tunda);
    			return $drop_tunda;
    		})         		
    		->addColumn('storting_tunda', function ($row) {
    			$storting_tunda = number_format($row->storting_tunda);
    			return $storting_tunda;
    		})         		
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-xs btn-warning" href="'. action('ProgramKerjaController@edit', $row->id) .'" >Edit</a>';
    			$action = $action .  '<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ProgramKerjaController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Reset</a>';
    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
    	}

    	$today =  date('Y-m-d');
    	$globalData = Perkembangan::selectRaw('sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp,
    		MAX(DAY(tanggal)) as hari_ke')
    	->whereMonth('tanggal',date('m'))
    	->whereYear('tanggal',date('Y'))
    	->where('cabang', auth()->user()->cabang_id)
    	->first();

    	return view('backend.perkembangan.data.index',compact('today','globalData'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	$request->validate([
    		'tanggal' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$cek = Perkembangan::where('tanggal', $request->tanggal)->where('cabang', auth()->user()->cabang_id)->first();
    		if(!empty($cek)){
    			toastr()->warning('Data Sudah Ada, Silahkan menggunakan fitur Edit', 'Peringatan');
    			return back();
    		}
    		Perkembangan::create([
    			"cabang" => auth()->user()->cabang_id,
    			"tanggal" => $request->tanggal,
    			"drops" => $request->drop,
    			"storting" => $request->storting,
    			"psp" => $request->psp,
    			"drop_tunda" => $request->drop_tunda,
    			"storting_tunda" => $request->storting_tunda,
    			"tkp" => $request->tkp,
    			"sisa_kas" => $request->sisa_kas,
    			'created_by' => auth()->user()->id,
    			'updated_by' => auth()->user()->id,
    		]);
    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah ditambahkan', 'Berhasil');
    	return redirect(action('PerkembanganController@create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function show(Perkembangan $perkembangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perkembangan $perkembangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perkembangan $perkembangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perkembangan $perkembangan)
    {
        //
    }

    public function global(Request $request)
    {
    	$kategori = $labels = [];
    	$chart = Perkembangan::selectRaw('
    		sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp, 
    		sum(sisa_kas) as sum_sisa_kas, 
    		cabang')
    	->whereMonth('tanggal',date('m'))
    	->groupBy('cabang')
    	->get();

    	// CHART
    	$labels = $chart->mapWithKeys(function ($item, $key) {
    		return [ucfirst($item->Cabang->cabang) => ucfirst($item->cabang)];
    	});
    	$labels = $labels->keys();
    	
    	foreach ($chart as $key => $value) {
    		$kategori['unit'][] = $value->Cabang->cabang;
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

    	// TABLE
    	$globalTable = $chart->mapWithKeys(function ($item, $key) {
    		return [ucfirst($item->Cabang->cabang) => [
    			'sum_drop' => $item->sum_drop,
    			'sum_psp' => $item->sum_psp,
    			'sum_storting' => $item->sum_storting,
    			'sum_drop_tunda' => $item->sum_drop_tunda,
    			'sum_storting_tunda' => $item->sum_storting_tunda,
    			'sum_tkp' => $item->sum_tkp,
    			'sum_sisa_kas' => $item->sum_sisa_kas,
    		]];
    	});

    	// PENCAPAIAN
    	$target = ProgramKerja::selectRaw('
    		sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp, 
    		sum(sisa_kas) as sum_sisa_kas')
    	->whereMonth('tanggal',date('m'))
    	->first();

    	$pencapaian =  Perkembangan::selectRaw('
    		sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp, 
    		sum(sisa_kas) as sum_sisa_kas')
    	->whereMonth('tanggal',date('m'))
    	->first();

    	    	// PERBANDINGAN
    	$perbandingaLables = [];
    	$bulanSekarang = Carbon::now()->subMonth(0)->format('m');
    	$bulanKemarin = Carbon::now()->subMonth(1)->format('m');
    	$jmlHariSekarang = Carbon::now()->subMonth(0)->endOfMonth()->format('d');
    	$jmlHariKemarin = Carbon::now()->subMonth(1)->endOfMonth()->format('d');
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

    	$perbandingaLables = $perbandingan->mapWithKeys(function ($item, $key) {
    		return ['hari ke ' . $item->hari => $item->sum_drop];
    	});
    	$perbandinganLabels = $perbandingaLables->keys();

    	$pencapaianBulanLalu =  Perkembangan::selectRaw('
    		sum(drops) as sum_drop, 
    		sum(psp) as sum_psp,
    		sum(storting) as sum_storting,
    		sum(drop_tunda) as sum_drop_tunda, 
    		sum(storting_tunda) as sum_storting_tunda, 
    		sum(tkp) as sum_tkp, 
    		sum(sisa_kas) as sum_sisa_kas')
    	->whereMonth('tanggal',$bulanKemarin)
    	->first();

    	$perbandinganDrop = json_encode($this->mappingData($perbandingan, 'sum_drop'));
    	$perbandinganStorting = json_encode($this->mappingData($perbandingan, 'sum_storting'));
    	$perbandinganTkp = json_encode($this->mappingData($perbandingan, 'sum_tkp'));
    	$perbandinganDropTunda = json_encode($this->mappingData($perbandingan, 'sum_drop_tunda'));
    	$perbandinganStortingTunda = json_encode($this->mappingData($perbandingan, 'sum_storting_tunda'));

    	return view('backend.perkembangan.global.index', compact('dataset','labels','target','pencapaian','globalTable','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda'));
    }

    private function mappingData($data, $keyword)
    {
    	$mapping = $data->mapToGroups(function ($item, $key) use ($keyword) {
    		$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
    		return [ $bulan  => $item->$keyword];
    	});

    	foreach ($mapping as $key => $value) {
    		$dataMappping[] = [ 
    			'label' => $key , 
    			'data' => $value->toArray(), 
    		];
    	}
    	return $dataMappping;
    	// $data = json_encode($storting);
    }
}
