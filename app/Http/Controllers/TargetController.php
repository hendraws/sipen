<?php

namespace App\Http\Controllers;

use App\AnggotaLalu;
use App\KantorCabang;
use App\Perkembangan;
use App\ProgramKerja;
use App\Resort;
use App\Target;
use App\TargetLalu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$psrn = 0;
    	$getTanggal = $request->tanggal;
    	$pecahTanggal = explode('-', $request->tanggal);

    	$programKerja = ProgramKerja::where('cabang', auth()->user()->cabang_id)
    	->when(request()->filled('tanggal'), function($q){
    		$q->whereMonth('tanggal', date('m', strtotime(request()->tanggal)));
    	})
    	->when(request()->missing('tanggal'), function($q){
    		$q->whereMonth('tanggal',date('m'));
    	})
    	->first();
    	
    	if(empty($programKerja)){
    		toastr()->error('Silahkan Mengisi Program Kerja Terlebih Dahulu', 'Warning !!!');
    		return redirect(action('ProgramKerjaController@index'));
    	}

    	if($request->ajax()) {

    		if(empty($request->tanggal)){
    			$cekWeekend = date('w', strtotime(date('Y-m-d')));
    		}else{
    			$cekWeekend = date('w', strtotime($request->tanggal));
    		}

    		if($cekWeekend == 1 || $cekWeekend == 4){
    			$psrn_name = "Senin - Kamis";
    			$psrn = 1;
    		}

    		if($cekWeekend == 2 || $cekWeekend == 5){
    			$psrn_name = "Selasa - Jum'at";
    			$psrn = 2;
    		}

    		if($cekWeekend == 3 || $cekWeekend == 6){
    			$psrn_name = "Rabu - Sabtu"; 
    			$psrn = 3;
    		}	

    		$data = Target::select("*")
    		->where('cabang_id', auth()->user()->cabang_id)
    		->where('pasaran', $psrn)
    		->when(request()->filled('tanggal'), function($q){
    			$q->whereMonth('tanggal', date('m', strtotime(request()->tanggal)))
    			->where('tanggal','<=',request()->tanggal);
    		})
    		->when(request()->missing('tanggal'), function($q){
    			$q->whereMonth('tanggal',date('m'));
    		})
    		->get();

    		$data = $data->mapToGroups(function ($item, $key) {
    			$targetAll = Target::selectRaw('sum(drop_kini) as total_drops,sum(storting_kini) as total_storting ')
    			->where('cabang_id', auth()->user()->cabang_id)
    			->where('resort_id', $item->resort_id)
    			// ->where('pasaran', $item->pasaran)
    			->whereMonth('tanggal',date('m', strtotime($item->tanggal)))
    			->first();
    			$item['total_drops'] = $targetAll->total_drops;
    			$item['total_storting'] = $targetAll->total_storting;
    			return [ $item->getResort->nama => $item->toArray() ];
    		}); 
    		
    		if($request->data == 'drop'){
    			return view('backend.target.drop.table', compact('data','programKerja','psrn_name'));
    		}
    		if($request->data == 'storting'){
    			return view('backend.target.storting.table', compact('data','programKerja','psrn_name'));
    		}

    		if($request->data == 'kalkulasi'){
    			return view('backend.target.kalkulasi.table', compact('data','programKerja','psrn_name'));
    		}


    		$targetLalu = TargetLalu::where('cabang_id',auth()->user()->getCabang->id)
    		->where('pasaran', $psrn)
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get()
    		->mapWithKeys(function ($item, $key) {
    			return [$item->getResort->nama => $item->target_lalu];
    		});

    		$anggotaLalu = AnggotaLalu::where('cabang_id',auth()->user()->getCabang->id)
    		->where('pasaran', $psrn)
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get()
    		->mapWithKeys(function ($item, $key) {
    			return [$item->getResort->nama => $item->anggota];
    		});

    		    		
    		return view('backend.target.table', compact('getTanggal','data','psrn_name','programKerja','psrn','targetLalu','anggotaLalu'));

    	}

    	$today =  date('Y-m-d');
    	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		$q->where('cabang_id', auth()->user()->cabang_id);
    	})->get();
    	$getTanggal = $today;
    	$cekWeekend = date('w', strtotime($today));

    	$pasaran =  [];

    	if($cekWeekend == 1 || $cekWeekend == 4){
    		$pasaran[1] = "Senin - Kamis"; 
    		// $psrn = "Senin - Kamis";
    		$psrn = 1;
    	}

    	if($cekWeekend == 2 || $cekWeekend == 5){
    		$pasaran[2] = "Selasa - Jum'at";
    		// $psrn = "Selasa - Jum'at";
    		$psrn = 2;
    	}

    	if($cekWeekend == 3 || $cekWeekend == 6){
    		$pasaran[3] = "Rabu - Sabtu";
    		// $psrn = "Rabu - Sabtu"; 
    		$psrn = 3; 
    	}


    	return view('backend.target.index', compact('today', 'resort','pasaran','getTanggal','psrn' ,'programKerja'));
    }

    public function index2(Request $request)
    {
    	$psrn = 0;
    	$getTanggal = $request->tanggal;
    	$pecahTanggal = explode('-', $request->tanggal);
    	$cabangId = $request->cabang ?? auth()->user()->cabang_id;
    	$programKerja = ProgramKerja::where('cabang', $cabangId)
    	->when(request()->filled('tanggal'), function($q){
    		$q->whereMonth('tanggal', date('m', strtotime(request()->tanggal)));
    	})
    	->when(request()->missing('tanggal'), function($q){
    		$q->whereMonth('tanggal',date('m'));
    	})
    	->first();
    
    	$cabang = KantorCabang::pluck('cabang','id');
    	
    	if(empty($programKerja)){
    		toastr()->error('Silahkan Mengisi Program Kerja Terlebih Dahulu', 'Warning !!!');
    		return redirect(action('ProgramKerjaController@index'));
    	}

    	if($request->ajax()) {

    		if(empty($request->tanggal)){
    			$cekWeekend = date('w', strtotime(date('Y-m-d')));
    		}else{
    			$cekWeekend = date('w', strtotime($request->tanggal));
    		}

    		if($cekWeekend == 1 || $cekWeekend == 4){
    			$psrn_name = "Senin - Kamis";
    			$psrn = 1;
    		}

    		if($cekWeekend == 2 || $cekWeekend == 5){
    			$psrn_name = "Selasa - Jum'at";
    			$psrn = 2;
    		}

    		if($cekWeekend == 3 || $cekWeekend == 6){
    			$psrn_name = "Rabu - Sabtu"; 
    			$psrn = 3;
    		}	

    		$data = Target::select("*")
    		->where('pasaran', $psrn)
    		->when(request()->filled('tanggal'), function($q){
    			$q->whereMonth('tanggal', date('m', strtotime(request()->tanggal)))
    			->where('tanggal','<=',request()->tanggal);
    		})
    		->when(request()->missing('tanggal'), function($q){
    			$q->whereMonth('tanggal',date('m'));
    		})
    		->when(request()->filled('cabang'), function($q){
    			$q->where('cabang_id', request()->cabang);
    		})
    		->when(request()->missing('cabang'), function($q) use ($cabangId){
    			$q->where('cabang_id', $cabangId);
    		})
    		->get();

    		$data = $data->mapToGroups(function ($item, $key) use ($cabangId){
    			$targetAll = Target::selectRaw('sum(drop_kini) as total_drops,sum(storting_kini) as total_storting ')
    			->where('cabang_id', $cabangId)
    			->where('resort_id', $item->resort_id)
    			// ->where('pasaran', $item->pasaran)
    			->whereMonth('tanggal',date('m', strtotime($item->tanggal)))
    			->first();
    			$item['total_drops'] = $targetAll->total_drops;
    			$item['total_storting'] = $targetAll->total_storting;
    			return [ $item->getResort->nama => $item->toArray() ];
    		}); 

    		if($request->data == 'drop'){
    			return view('backend.target.drop.table', compact('data','programKerja','psrn_name'));
    		}
    		if($request->data == 'storting'){
    			return view('backend.target.storting.table', compact('data','programKerja','psrn_name'));
    		}

    		if($request->data == 'kalkulasi'){
    			return view('backend.target.kalkulasi.table', compact('data','programKerja','psrn_name'));
    		}


    		$targetLalu = TargetLalu::where('cabang_id',$cabangId)
    		->where('pasaran', $psrn)
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get()
    		->mapWithKeys(function ($item, $key) {
    			return [$item->getResort->nama => $item->target_lalu];
    		});

    		$anggotaLalu = AnggotaLalu::where('cabang_id',$cabangId)
    		->where('pasaran', $psrn)
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get()
    		->mapWithKeys(function ($item, $key) {
    			return [$item->getResort->nama => $item->anggota];
    		});


    		return view('backend.target.table', compact('getTanggal','data','psrn_name','programKerja','psrn','targetLalu','anggotaLalu'));

    	}

    	$today =  date('Y-m-d');
    	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		$q->where('cabang_id', auth()->user()->cabang_id);
    	})->get();
    	$getTanggal = $today;
    	$cekWeekend = date('w', strtotime($today));

    	$pasaran =  [];

    	if($cekWeekend == 1 || $cekWeekend == 4){
    		$pasaran[1] = "Senin - Kamis"; 
    		// $psrn = "Senin - Kamis";
    		$psrn = 1;
    	}

    	if($cekWeekend == 2 || $cekWeekend == 5){
    		$pasaran[2] = "Selasa - Jum'at";
    		// $psrn = "Selasa - Jum'at";
    		$psrn = 2;
    	}

    	if($cekWeekend == 3 || $cekWeekend == 6){
    		$pasaran[3] = "Rabu - Sabtu";
    		// $psrn = "Rabu - Sabtu"; 
    		$psrn = 3; 
    	}


    	return view('backend.target.index_admin', compact('today', 'resort','pasaran','getTanggal','psrn' ,'programKerja','cabang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	$target = $request->validate([
    		'resort_id' => 'required',
    		'tanggal' => 'required',
    		'target_drops' => 'required',
    		'storting_kini' => 'required',
    		'target_plnsn' => 'required',
    		'anggota_lama' => 'required',
    		'anggota_baru' => 'required',
    		'anggota_out' => 'required',
    		'pasaran' => 'required',
    	]);

    	DB::beginTransaction();
    	try {

    		$anggota = AnggotaLalu::where('pasaran', $request->pasaran)
    		->where('resort_id',$request->resort_id)
    		->whereMonth('tanggal', date('m'))
    		->first();
    		$cekTarget = Target::where('pasaran', $request->pasaran)
    		->where('resort_id',$request->resort_id)
    		->whereMonth('tanggal', date('m'))
    		->first();
    		$cekDropLalu = Target::where('resort_id',$request->resort_id)
    		->latest()
    		->first();
    		$targetLalu = TargetLalu::where('pasaran', $request->pasaran)
    		->where('resort_id',$request->resort_id)
    		->whereMonth('tanggal', date('m'))
    		->first();

    		$target['cabang_id'] = auth()->user()->cabang_id; 
    		$target['created_by'] = auth()->user()->id; 
    		$target['drop_kini'] = $request->target_drops;
    		if(empty($cekTarget)){
    			if(empty($anggota)){
    				toastr()->warning('Silahkan Input Data Master Anggota Terlebih Dahulu!', 'Perhatian');
    				return back();
    			}
    			if(empty($targetLalu)){
    				toastr()->warning('Silahkan Input Data Master Target Lalu Terlebih Dahulu!', 'Perhatian');
    				return back();
    			}
    			$target['anggota_lalu'] = $anggota->anggota;
    			$target['target_lalu'] = $targetLalu->target_lalu;
    		}


    		// $target['anggota_kini'] = $target['anggota_lalu'] + $target['anggota_lama'] + $target['anggota_baru'] - $target['anggota_out'];

    		// if(!empty($cekDropLalu)){
    		// 	$target['target_lalu'] = $cekDropLalu->target_kini;
    		// }else{
    		// 	$target['target_lalu'] = 0;
    		// }
    		$target['target_20_drop'] = ($request->target_drops * 20) / 100;
    		$target['target_20_plnsn'] = ($request->target_plnsn * 20) / 100;
    		// $target['target_kini'] = $target['target_lalu'] + $target['target_20_drop']  - $target['target_20_plnsn'];
    		// dd($target,$anggota, $request,$cekTarget);

    		// $cekKemacetan  = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		// ->where('resort_id', $request->resort_id)
    		// ->where('pasaran', $request->pasaran)
    		// ->whereMonth('tanggal',now()->month)
    		// ->first();
    		// if(!empty($cekKemacetan)){
    		// 	toastr()->warning('Data Sudah Ada', 'Error');
    		// 	return back();
    		// }
    		Target::create($target);
    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah ditambahkan', 'Berhasil');
    	return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	// dd(auth()->user()->getCabang->id);
    	$data = Target::where('cabang_id',auth()->user()->getCabang->id)->where('resort_id',$id)->whereMonth('tanggal', Date('m'))->orderBy('tanggal')->get();
    	$targetLalu = TargetLalu::where('cabang_id',auth()->user()->getCabang->id)
    	->where('resort_id',$id)
    	->whereMonth('tanggal', Date('m'))
    	->orderBy('pasaran')
    	->get();

    	$targetLalu = $targetLalu->mapWithKeys(function ($item, $key) {
    		return [$item->pasaran => $item->target_lalu];
    	});

    	$anggotaLalu = AnggotaLalu::where('cabang_id',auth()->user()->getCabang->id)
    	->where('resort_id',$id)
    	->whereMonth('tanggal', Date('m'))
    	->orderBy('pasaran')
    	->get()
    	->mapWithKeys(function ($item, $key) {
    		return [$item->pasaran => $item->anggota];
    	});
    	return view('backend.target.detail', compact('data','targetLalu','anggotaLalu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data = Target::where('id', $id)->first();

    	return view('backend.target.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	
    	$target = $request->validate([
    		'resort_id' => 'required',
    		'tanggal' => 'required',
    		'target_drops' => 'required',
    		'storting_kini' => 'required',
    		'target_plnsn' => 'required',
    		'anggota_lama' => 'required',
    		'anggota_baru' => 'required',
    		'anggota_out' => 'required',
    		'pasaran' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$data = Target::find($id);
    		$cekData  = Target::where('resort_id', $request->resort_id)->where('tanggal', $request->tanggal)->first();
    		if(!empty($cekData) && ($request->tanggal != $data->tanggal)){
    			toastr()->error('Tanggal Yang Di input Sudah Ada, Silahkan Edit Di tanggal Tersebut !!!', 'Warning');
    			return back();
    		}
    		
    		$target['cabang_id'] = auth()->user()->cabang_id; 
    		$target['created_by'] = auth()->user()->id; 
    		$target['target_20_drop'] = ($request->target_drops * 20) / 100;
    		$target['target_20_plnsn'] = ($request->target_plnsn * 20) / 100;

    		Target::where('id',$id)->update($target);
    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah diubah', 'Berhasil');
    	return redirect(action('TargetController@show', $request->resort_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
    	$target->delete();
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return redirect(action('TargetController@show', $target->resort_id));
    }

    public function delete(Target $target)
    {
    	return view('backend.target.delete', compact('target'));
    }

    public function storeHk(Request $request)
    {
    	DB::beginTransaction();
    	try {
    		// dd($request);
    		ProgramKerja::where('id',$request->program_kerja_id)->update(['sisa_hk' => $request->sisa_hk]);	
    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Berhasil Setting Sisa Kerja', 'Berhasil');
    	return back();
    }

    public function cetak(Request $request)
    {
    	dd($request);

    }

    // public function index2(Request $request)
    // {
    // 	if($request->ajax()) {
    // 		$cekWeekend = date('w', strtotime($request->tanggal));
    // 		if($cekWeekend == 1 || $cekWeekend == 4){
    // 			$psrn = "Senin - Kamis";
    // 		}

    // 		if($cekWeekend == 2 || $cekWeekend == 5){
    // 			$psrn = "Selasa - Jum'at";
    // 		}

    // 		if($cekWeekend == 3 || $cekWeekend == 6){
    // 			$psrn = "Rabu - Sabtu"; 
    // 		}	
    // 		$getTanggal = $request->tanggal;
    // 		$data = Target::select("*")
    // 		->where('tanggal',$request->tanggal)
    // 		->where('cabang_id', auth()->user()->cabang_id)
    // 			// ->where('pasaran', $pasaran)
    // 		->orderBy('created_at', 'desc')
    // 		->get()
    // 		->unique('resort_id')
    // 		;

    // 		return view('backend.target.table', compact('getTanggal','data','psrn'));

    // 	}
    // 	// dd('dd');
    // 	$today =  date('Y-m-d');
    // 	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		// $q->where('cabang_id', auth()->user()->cabang_id);
    	// })->get();
    // 	$getTanggal = $today;
    // 	$cekWeekend = date('w', strtotime($today));

    // 	$pasaran =  [];

    // 	if($cekWeekend == 1 || $cekWeekend == 4){
    // 		$pasaran[1] = "Senin - Kamis"; 
    // 		$psrn = "Senin - Kamis";
    // 	}

    // 	if($cekWeekend == 2 || $cekWeekend == 5){
    // 		$pasaran[2] = "Selasa - Jum'at";
    // 		$psrn = "Selasa - Jum'at";
    // 	}

    // 	if($cekWeekend == 3 || $cekWeekend == 6){
    // 		$pasaran[3] = "Rabu - Sabtu";
    // 		$psrn = "Rabu - Sabtu"; 
    // 	}

    // 	$data = Target::select("*")
    // 	->where('tanggal',$today)
    // 	->where('cabang_id', auth()->user()->cabang_id)
    // 			// ->where('pasaran', $pasaran)
    // 	->orderBy('created_at', 'desc')
    // 	->get()
    // 	->unique('resort_id')
    // 	;

    // 	return view('backend.target.index', compact('today', 'resort','pasaran','data','getTanggal','psrn' ));
    // }

    public function report(Request $request)
    {

    	if($request->has('tanggal')){
    		$target  = Target::with('getResort')
    		->whereMonth('tanggal', date('m',strtotime($request->tanggal)) )
    		->orderBy('tanggal')
    		->when(request()->filled('cabang'), function($q){
    			$q->where('cabang_id', request()->cabang);
    		})
    		->when(request()->missing('cabang'), function($q){
    			$q->where('cabang_id', auth()->user()->cabang_id);
    		})
    		->get();

    		$data = $target->mapToGroups(function($item, $key){
    			return [$item->tanggal => [ optional($item->getResort)->nama => $item ] ];
    		});
    		// $first_key = array_key_first($data->toArray());
    		$tanggal_awal = date('d F Y', strtotime(array_key_first($data->toArray())));
    		$tanggal_akhir = date('d F Y', strtotime(array_key_last($data->toArray())));


    		$targetLalu = TargetLalu::when(request()->filled('cabang'), function($q){
    			$q->where('cabang_id', request()->cabang);
    		})
    		->when(request()->missing('cabang'), function($q){
    			$q->where('cabang_id', auth()->user()->cabang_id);
    		})
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get();

    		$anggotaLalu = AnggotaLalu::when(request()->filled('cabang'), function($q){
    			$q->where('cabang_id', request()->cabang);
    		})
    		->when(request()->missing('cabang'), function($q){
    			$q->where('cabang_id', auth()->user()->cabang_id);
    		})
    		->whereMonth('tanggal', Date('m'))
    		->orderBy('pasaran')
    		->get();
    		
    		$anggota_lalu = $target_lalu = [];
    		// ->mapWithKeys(function ($item, $key) use ($resort){
    		// 	$resort = $item->getResort->nama; 
    		// 	return [ $item->getResort->nama =>   $item->anggota];
    		// });
    		foreach ($targetLalu as $key => $value) {
    			
    			$target_lalu[$value->getResort->nama][$value->pasaran] = $value->target_lalu; 
    		}

    		foreach ($anggotaLalu as $key => $value) {
    			$anggota_lalu[$value->getResort->nama][$value->pasaran] = $value->anggota; 
    		}

    		$pdf = PDF::loadView('backend.target.report', compact('data', 'tanggal_awal', 'tanggal_akhir','anggota_lalu', 'target_lalu'))->setPaper('a4', 'landscape');

    		return $pdf->download('report-target.pdf');
    	}
    	return abort(404);
    }
}
