<?php

namespace App\Http\Controllers;

use App\AngsuranCalonMacet;
use App\AngsuranKemacetan;
use App\CalonMacet;
use App\KantorCabang;
use App\Kemacetan;
use App\Perkembangan;
use App\ProgramKerja;
use App\Resort;
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
    	return redirect(action('PerkembanganController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    	if($request->ajax()) {
    		$pecah = explode( '/',$request->tanggal);

    		$getTanggal = $request->tanggal."/01";
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];

    		$globalData = Perkembangan::selectRaw('sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp,
    			MAX(DAY(tanggal)) as hari_ker')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->where('cabang', auth()->user()->cabang_id)
    		->first();

    		$data = Perkembangan::where('cabang', auth()->user()->cabang_id)
    		->select('*')
    		->selectRaw('DAY(tanggal) as hari')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->orderBy('tanggal','asc')
    		->get();
    		
    		// ->addColumn('action', function ($row) {
    		// 	$action =  '<a class="btn btn-xs btn-warning" href="'. action('ProgramKerjaController@edit', $row->id) .'" >Edit</a>';
    		// 	$action = $action .  '<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ProgramKerjaController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Reset</a>';
    		// 	return $action;
    		// })

    		return view('backend.perkembangan.data.table',compact('globalData','data','getTanggal'));
    	}

    	$today =  date('Y-m-d');
    	

    	return view('backend.perkembangan.data.index',compact('today'));

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

    		$cekHari = Perkembangan::where('cabang', auth()->user()->cabang_id)
    		->whereMonth('tanggal', Carbon::createFromFormat('Y-m-d', $request->tanggal)->format('m'))->latest()->first();
    		$hariKerja = 0;
    		if(!empty($cekHari)){
    			$hariKerja = $cekHari->hari_kerja;
    		}

    		$drop_tunda = $storting_tunda = 0;

    		$drop_tunda = $request->drop_tunda_masuk  - $request->drop_tunda_keluar;
    		$storting_tunda = $request->angsuran_tunda_masuk  - $request->angsuran_tunda_keluar;

    		$a = Perkembangan::create([
    			"cabang" => auth()->user()->cabang_id,
    			"tanggal" => $request->tanggal,
    			"drops" => $request->drop,
    			"storting" => $request->storting,
    			"psp" => $request->psp,
    			"drop_tunda" => $drop_tunda,
    			"drop_tunda_masuk" => $request->drop_tunda_masuk,
    			"drop_tunda_keluar" => $request->drop_tunda_keluar,
    			"storting_tunda" => $storting_tunda,
    			"angsuran_tunda_masuk" => $request->angsuran_tunda_masuk,
    			"angsuran_tunda_keluar" => $request->angsuran_tunda_keluar,
    			"tkp" => $request->tkp,
    			"sisa_kas" => $request->sisa_kas,
    			"hari_kerja" => $hariKerja + 1,
    			'created_by' => auth()->user()->id,
    			'updated_by' => auth()->user()->id,
    		]);
    		// dd($a);
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
    public function edit($id)
    {

    	$data  = Perkembangan::find($id);
    	return view('backend.perkembangan.data.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	DB::beginTransaction();
    	try {
    		Perkembangan::whereId($id)->update([
    			// "cabang" => $request->cabang,
    			// "tanggal" => $request->tanggal,
    			"drops" => $request->drop,
    			"storting" => $request->storting,
    			"psp" => $request->psp,
    			"drop_tunda" => $request->drop_tunda,
    			"storting_tunda" => $request->storting_tunda,
    			"tkp" => $request->tkp,
    			"sisa_kas" => $request->sisa_kas,
    			"hari_kerja" => $request->hari_kerja,
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
    	toastr()->success('Data telah Diubah', 'Berhasil');
    	return redirect(action('PerkembanganController@create'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perkembangan  $perkembangan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$data = Perkembangan::find($id);
    	$data->delete();
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }

    public function global(Request $request)
    {
    	if($request->ajax()) {
    		$pecah = explode( '/',$request->tanggal);
    		$tanggal = Carbon::createFromFormat('Y/m/d', $request->tanggal."/01");
    		$getBulan = $tanggal->isoFormat('MMMM YYYY');
    		$getTanggal = $request->tanggal."/01";
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];

    		$kategori = $labels = [];
    		$chart = Perkembangan::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas, 
    			cabang, count(tanggal) as hk')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->groupBy('cabang')
    		->get();

    	// CHART
    		$labels = $chart->mapWithKeys(function ($item, $key) {
    			return [ucfirst(optional($item->Cabang)->cabang) => ucfirst($item->cabang)];
    		});
    		$labels = $labels->keys();

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

    	// TABLE
    		$globalTable = $chart->mapWithKeys(function ($item, $key) {
    			return [ucfirst(optional($item->Cabang)->cabang) => [
    				'sum_drop' => $item->sum_drop,
    				'sum_psp' => $item->sum_psp,
    				'sum_storting' => $item->sum_storting,
    				'sum_drop_tunda' => $item->sum_drop_tunda,
    				'sum_storting_tunda' => $item->sum_storting_tunda,
    				'sum_tkp' => $item->sum_tkp,
    				'sum_sisa_kas' => $item->sum_sisa_kas,
    				'hk' => $item->hk,
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
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->first();

    		$pencapaian =  Perkembangan::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->first();
    		// dd($tahun);
    	    	// PERBANDINGAN
    		$perbandingaLables = [];
    		$bulanKemarin = $tanggal->subMonth(1)->format('m');
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
    		->whereIn(DB::raw('MONTH(tanggal)'),[$bulanKemarin,$bulan])
    		->whereYear('tanggal',$tahun)
    		->groupBy('tanggal')
    		->get();

    		$perbandingaLables = $perbandingan->mapToGroups(function ($item, $key) {
    			return ['hari ke ' . $item->bulan => $item->sum_drop];
    		});
    		// dd($perbandingaLables);
    		$jmlHari = $dataLabel = [];
    		foreach($perbandingaLables as $jumlahHari){
    			$jmlHari[] = count($jumlahHari);
    		}
    		if(count($jmlHari) > 0){
    			for ($i=1; $i <= max($jmlHari) ; $i++) { 
    				$dataLabel[] = $i;
    			}
    		}

    		
    		$perbandinganLabels = json_encode($dataLabel);

    	// $perbandingaLables = $perbandingan->mapWithKeys(function ($item, $key) {
    	// 	return ['hari ke ' . $item->hari => $item->sum_drop];
    	// });
    	// $perbandinganLabels = $perbandingaLables->keys();

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

    		
    		if($request->print == 'true'){
    			return view('backend.perkembangan.global.cetak', compact('dataset','labels','target','pencapaian','globalTable','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda','getBulan'));
    		}
    		// return view('backend.perkembangan.data.table',compact('globalData','data','getTanggal'));
    		return view('backend.perkembangan.global.all-data', compact('dataset','labels','target','pencapaian','globalTable','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda', 'getBulan'));
    	}

    	return view('backend.perkembangan.global.index');
    }

    private function mappingData($data, $keyword)
    {
    	$cummulative = $dataMappping = [];
    	$mapping = $data->mapToGroups(function ($item, $key) use ($keyword) {
    		$bulan = Carbon::create()->month($item->bulan)->startOfMonth()->format('F');
    		return [ $bulan  => $item->$keyword];
    	});

    	foreach($mapping as $k => $v){
    		$cum = 0;
    		foreach($v as $val){
    			$cummulative[$k][] = $cum +=$val;
    		} 
    	}
    	foreach ($cummulative as $key => $value) {
    		$dataMappping[] = [ 
    			'label' => $key , 
    			'data' => $value, 
    		];
    	}
    	return $dataMappping;
    	// $data = json_encode($storting);
    }

    public function cabang(Request $request)
    {
    	$user = auth()->user();
    	if($user->getRoleNames()->first() == 'admin')
    	{
    		$cabang = KantorCabang::pluck('cabang','id');
    	}

    	if($user->getRoleNames()->first() == 'user')
    	{
    		$cabang = KantorCabang::where('id', $user->cabang_id )->pluck('cabang','id');
    	}

    	if($request->ajax()){
    		$tgl = $request->tanggal;
    		$pecah = explode( '/',$request->tanggal);
    		$tanggal = Carbon::createFromFormat('Y/m/d', $request->tanggal."/01");
    		$getBulan = $tanggal->isoFormat('MMMM YYYY');
    		$getTanggal = $request->tanggal."/01";
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];

    		// get data kemacetan 
    		if($request->data == 'kemacetan'){
    			$kemacetan = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    			->whereMonth('tanggal',$bulan)
    			->get();

    			$groupKemacetan = $kemacetan->mapToGroups(function ($item, $key) {
    				return [$item->getResort->nama => $item];
    			});
    			// dd($groupKemacetan->toArray());
    			$evaluasi = Kemacetan::leftjoin('angsuran_kemacetans','angsuran_kemacetans.kemacetan_id', 'kemacetans.id' )
    			->join('pasarans','pasarans.id', 'kemacetans.pasaran')
    			->leftjoin('resorts','resorts.id', 'kemacetans.resort_id')
    			->where('kemacetans.cabang_id', auth()->user()->cabang_id) 
    			->whereMonth('kemacetans.tanggal',$bulan)
    			->selectRaw('
    				ma_saldo as total_ma_saldo,
    				mb_saldo as total_mb_saldo, 
    				sum(angsuran) as jml_angsuran, 
    				kemacetans.pasaran, 
    				kemacetans.resort_id, 
    				hari, 
    				resorts.nama as nama_resort, 
    				ma_anggota + mb_anggota as anggota,
    				sum(anggota_keluar) as anggota_keluar,
    				count(angsuran_kemacetans.tanggal) as hk
    				')
    			->groupBy('kemacetans.resort_id')
    			->groupBy('kemacetans.pasaran')
    			->get();
    			
    			$evaluasiBerjalan = $evaluasi->mapToGroups(function ($item, $key) {
    				return [$item->nama_resort => $item];
    			});

    			// grafik
    			$anggsuran = AngsuranKemacetan::whereMonth('tanggal',$bulan)
    			->selectRaw('tanggal, 
    				MONTH(tanggal) as bulan, 
    				DAY(tanggal) as hari,angsuran,cabang_id, resort_id')
    			->where('cabang_id', auth()->user()->cabang_id) 
    			->orderBy('tanggal')
    			->get();


    			$anggsuranLabels = $anggsuran->mapToGroups(function ($item, $key) {
    				return [ $item->getResort->nama => $item->angsuran];
    			});
    			$jmlHari =$dataLabel= [];
    			foreach($anggsuranLabels as $jumlahHari){
    				$jmlHari[] = count($jumlahHari);
    			}
    			if(count($jmlHari) > 0){
    				for ($i=1; $i <= max($jmlHari) ; $i++) { 
    					$dataLabel[] = 'HK '.$i;
    				}
    			}

    			$dataMappping = [];
    			foreach ($anggsuranLabels as $key => $value) {
    				$dataMappping[] = [ 
    					'label' => $key , 
    					'data' => $value->toArray(), 
    				];
    			}
    			$labelGrafik = json_encode($dataLabel);
    			$dataGrafik = json_encode($dataMappping);
    			return view('backend.perkembangan.kantor_cabang.kemacetan.index', compact('groupKemacetan','evaluasiBerjalan','labelGrafik','dataGrafik'));
    		}    		


    		if($request->data == 'calonMacet'){

    			$calonMacet = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    			->whereMonth('tanggal',$bulan)
    			->get();

    			$groupCalonMacet = $calonMacet->mapToGroups(function ($item, $key) {
    				return [$item->getResort->nama => $item];
    			});

    			$evaluasi = CalonMacet::leftjoin('angsuran_calon_macets','angsuran_calon_macets.calon_macet_id', 'calon_macets.id' )
    			->join('pasarans','pasarans.id', 'calon_macets.pasaran')
    			->leftjoin('resorts','resorts.id', 'calon_macets.resort_id')
    			->where('calon_macets.cabang_id', auth()->user()->cabang_id) 
    			->whereMonth('calon_macets.tanggal',$bulan)
    			->selectRaw('
    				cma_saldo as total_cma_saldo,
    				sum(angsuran) as jml_angsuran, 
    				calon_macets.pasaran, 
    				calon_macets.resort_id, 
    				hari, 
    				resorts.nama as nama_resort, 
    				cma_anggota as anggota,
    				sum(anggota_keluar) as anggota_keluar,
    				count(angsuran_calon_macets.tanggal) as hk
    				')
    			->groupBy('calon_macets.resort_id')
    			->groupBy('calon_macets.pasaran')
    			->get();

    			$evaluasiBerjalan = $evaluasi->mapToGroups(function ($item, $key) {
    				return [$item->nama_resort => $item];
    			});

    			// grafik
    			$anggsuran = AngsuranCalonMacet::whereMonth('tanggal',$bulan)
    			->selectRaw('tanggal, 
    				MONTH(tanggal) as bulan, 
    				DAY(tanggal) as hari,angsuran,cabang_id, resort_id')
    			->where('cabang_id', auth()->user()->cabang_id) 
    			->orderBy('tanggal')
    			->get();

    			$anggsuranLabels = $anggsuran->mapToGroups(function ($item, $key) {
    				return [ $item->getResort->nama => $item->angsuran];
    			});
    			$jmlHari = $dataLabel = [];
    			foreach($anggsuranLabels as $jumlahHari){
    				$jmlHari[] = count($jumlahHari);
    			}
    			if(count($jmlHari) > 0){
    				for ($i=1; $i <= max($jmlHari) ; $i++) { 
    					$dataLabel[] = 'HK '.$i;
    				}
    			}

    			$dataMappping = [];
    			foreach ($anggsuranLabels as $key => $value) {
    				$dataMappping[] = [ 
    					'label' => $key , 
    					'data' => $value->toArray(), 
    				];
    			}
    			$labelGrafik = json_encode($dataLabel);
    			$dataGrafik = json_encode($dataMappping);
    			return view('backend.perkembangan.kantor_cabang.calon_macet.index', compact('groupCalonMacet','evaluasiBerjalan','labelGrafik','dataGrafik'));
    		}

    		if($request->data == 'dataKalkulasi'){
    			
    			// $calonMacet = CalonMacet::leftjoin('angsuran_calon_macets','angsuran_calon_macets.calon_macet_id', 'calon_macets.id' )
    			// ->join('pasarans','pasarans.id', 'calon_macets.pasaran')
    			// ->leftjoin('resorts','resorts.id', 'calon_macets.resort_id')
    			// ->where('calon_macets.cabang_id', auth()->user()->cabang_id) 
    			// ->whereMonth('calon_macets.tanggal',$bulan)
    			// ->selectRaw('
    			// 	sum(cma_saldo) as total_cma_saldo,
    			// 	sum(angsuran) as jml_angsuran,
    			// 	calon_macets.resort_id, 
    			// 	resorts.nama as nama_resort,
    			// 	sisa_hk,
    			// 	target
    			// 	')
    			// ->groupBy('calon_macets.resort_id')
    			// ->get();			
    			$calonMacet = CalonMacet::where('calon_macets.cabang_id', auth()->user()->cabang_id) 
    			->whereMonth('calon_macets.tanggal',$bulan)
    			->selectRaw('
    				sum(target) as target,
    				sisa_hk,
    				sum(sisa_angsuran) as sisa_angsuran,
    				resort_id
    				')
    			->groupBy('calon_macets.resort_id')
    			->get();

    			$kemacetan = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    			->whereMonth('tanggal',$bulan)
    			->selectRaw('
    				sum(target) as target,
    				sisa_hk,
    				sum(sisa_angsuran) as sisa_angsuran,
    				resort_id
    				')
    			->groupBy('resort_id')
    			->get();
    			return view('backend.perkembangan.kantor_cabang.kalkulasi.index', compact('calonMacet', 'request','kemacetan'));
    		}

    		$dashboard = Perkembangan::selectRaw('sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp')
    		->where('cabang', $request->cabang)
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->first();

    		$kasTerbaru = Perkembangan::where('cabang', $request->cabang)
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->latest()->first();    	

			//PENCAPAIAN
    		$target = ProgramKerja::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->where('cabang', $request->cabang)
    		->first();

    		$pencapaian =  Perkembangan::selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->where('cabang', $request->cabang)
    		->first();

    		// Perbandingan
    		$perbandingaLables = $jmlHari = $dataLabel =[];
    		$bulanKemarin = $tanggal->subMonth(1)->format('m');

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
    		->whereIn(DB::raw('MONTH(tanggal)'),[$bulanKemarin,$bulan])
    		->where('cabang', $request->cabang)
    		->whereYear('tanggal',$tahun)
    		->groupBy('tanggal')
    		->get();

    		$perbandingaLables = $perbandingan->mapToGroups(function ($item, $key) {
    			return ['hari ke ' . $item->bulan => $item->sum_drop];
    		});
    		// dd($perbandingaLables);
    		foreach($perbandingaLables as $jumlahHari){
    			$jmlHari[] = count($jumlahHari);
    		}
    		if(count($jmlHari) > 0){

    			for ($i=1; $i <= max($jmlHari) ; $i++) { 
    				$dataLabel[] = $i;
    			}
    		}
    		
    		$perbandinganLabels = json_encode($dataLabel);

    		$hk = Perkembangan::select('tanggal')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->where('cabang', $request->cabang)
    		->get()->count();
    		
    		$pencapaianBulanLalu = [];
    		$pencapaianBulanLalu['sum_drop'] = 0;
    		$pencapaianBulanLalu['sum_psp'] = 0;
    		$pencapaianBulanLalu['sum_storting'] = 0;
    		$pencapaianBulanLalu['sum_drop_tunda'] = 0;
    		$pencapaianBulanLalu['sum_storting_tunda'] = 0;
    		$pencapaianBulanLalu['sum_tkp'] = 0;
    		$pencapaianBulanLalu['sum_sisa_kas'] = 0;

    		$sum_drop = $sum_psp = $sum_storting = $sum_drop_tunda = $sum_storting_tunda = $sum_tkp = $sum_sisa_kas = 0;
    		$getPencapaianBulanLalu =  Perkembangan::select('tanggal')->selectRaw('
    			sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp, 
    			sum(sisa_kas) as sum_sisa_kas')
    		->whereMonth('tanggal',$bulanKemarin)
    		->where('cabang', $request->cabang)
    		->groupBy('tanggal')
    		->take($hk)
    		->get();

    		foreach ($getPencapaianBulanLalu as $key => $value) {
    			$sum_drop += $value->sum_drop;
    			$sum_psp += $value->sum_psp;
    			$sum_storting += $value->sum_storting;
    			$sum_drop_tunda += $value->sum_drop_tunda;
    			$sum_storting_tunda += $value->sum_storting_tunda;
    			$sum_tkp += $value->sum_tkp;
    			$sum_sisa_kas += $value->sum_sisa_kas;
    			$pencapaianBulanLalu['sum_drop'] = $sum_drop;
    			$pencapaianBulanLalu['sum_psp'] =$sum_psp;
    			$pencapaianBulanLalu['sum_storting'] = $sum_storting;
    			$pencapaianBulanLalu['sum_drop_tunda'] = $sum_drop_tunda;
    			$pencapaianBulanLalu['sum_storting_tunda'] = $sum_storting_tunda;
    			$pencapaianBulanLalu['sum_tkp'] = $sum_tkp;
    			$pencapaianBulanLalu['sum_sisa_kas'] =  $value->sum_sisa_kas;
    		}
    		
    		$perbandinganDrop = json_encode($this->mappingData($perbandingan, 'sum_drop'));
    		$perbandinganStorting = json_encode($this->mappingData($perbandingan, 'sum_storting'));
    		$perbandinganTkp = json_encode($this->mappingData($perbandingan, 'sum_tkp'));
    		$perbandinganDropTunda = json_encode($this->mappingData($perbandingan, 'sum_drop_tunda'));
    		$perbandinganStortingTunda = json_encode($this->mappingData($perbandingan, 'sum_storting_tunda'));

    		if($request->print == 'true'){
    			$cabang = $request->cabang;
    			return view('backend.perkembangan.kantor_cabang.cetak', compact('dashboard', 'kasTerbaru','target','pencapaian','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda','getBulan','tgl','cabang'));
    		}
    		return view('backend.perkembangan.kantor_cabang.data_cabang', compact('dashboard', 'kasTerbaru','target','pencapaian','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda'));
    	}
    	return view('backend.perkembangan.kantor_cabang.index', compact('cabang'));
    }

    public function cetak()
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
    		return [ucfirst(optional($item->Cabang)->cabang) => ucfirst($item->cabang)];
    	});
    	$labels = $labels->keys();
    	
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

    	// TABLE
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

    	return view('backend.perkembangan.global.cetak', compact('dataset','labels','target','pencapaian','globalTable','perbandinganLabels','perbandinganDrop','pencapaianBulanLalu','perbandinganStorting','perbandinganTkp','perbandinganDropTunda','perbandinganStortingTunda'));
    }

    public function printHarian()
    {
    	$data = Perkembangan::where('cabang', auth()->user()->cabang_id)
    	->select('*')
    	->selectRaw('DAY(tanggal) as hari')
    	->whereMonth('tanggal',date('m'))
    	->whereYear('tanggal',date('Y'))
    	->orderBy('tanggal','asc')
    	->get();
    	return view('backend.perkembangan.data.print', compact('data'));
    }

    public function reset($id)
    {
    	// dd($id);
    	$data = Perkembangan::find($id);
    	$data->drops = 0;
    	$data->storting = 0;
    	$data->psp = 0;
    	$data->tkp = 0;
    	$data->drop_tunda = 0;
    	$data->storting_tunda = 0;
    	$data->sisa_kas = 0;
    	$data->updated_by = auth()->user()->id;
    	$data->save();
    	toastr()->success('Data telah reset', 'Berhasil');
    	return back();
    }


    public function resetModal($id)
    {
    	
    	$data = Perkembangan::find($id);
    	return view('backend.perkembangan.data.reset', compact('data'));
    } 

    public function delete($id)
    {
    	
    	$data = Perkembangan::find($id);
    	return view('backend.perkembangan.data.delete', compact('data'));
    }

    public function setHk(Request $request)
    {

    	$data = $request->all();
    	return view('backend.perkembangan.kantor_cabang.kalkulasi.create_modal', compact('data'));
    }

    public function storeHk(Request $request)
    {
    	$request->validate([
    		'sisa_hk' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$pecah = explode( '/',$request->tanggal);
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];
    		// dd($request);
    		$calonMacet = CalonMacet::where('cabang_id', auth()->user()->cabang_id) 
    		->whereMonth('tanggal',$bulan)
    		->get();

    		foreach($calonMacet as $val){
    			$target = $val->sisa_angsuran / $request->sisa_hk;
    			$val->update([
    				'sisa_hk' => $request->sisa_hk,
    				'target' => $target,
    			]);
    		}

    		$kemacetan = Kemacetan::where('cabang_id', auth()->user()->cabang_id) 
    		->whereMonth('tanggal',$bulan)
    		->get();

    		foreach($kemacetan as $val){
    			$target = $val->sisa_angsuran / $request->sisa_hk;
    			$val->update([
    				'sisa_hk' => $request->sisa_hk,
    				'target' => $target,
    			]);
    		}

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
    	return back();

    	return view('backend.perkembangan.kantor_cabang.kalkulasi.create_modal');
    }

}
