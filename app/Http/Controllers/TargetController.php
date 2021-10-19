<?php

namespace App\Http\Controllers;

use App\AnggotaLalu;
use App\Resort;
use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if($request->ajax()) {
    		$pecah = explode( '/',$request->tanggal);
    		$getTanggal = $request->tanggal."/01";
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];

    		if($request->data == 'dataTarget'){
    			$today =  date('Y-m-d');

    			$cekWeekend = date('w', strtotime($today));

    			$pasaran =  0;

    			if($cekWeekend == 1 || $cekWeekend == 4){
    				// $pasaran[1] = "Senin - Kamis";
    				$pasaran = 1;
    			}

    			if($cekWeekend == 2 || $cekWeekend == 5){
    				// $pasaran[2] = "Selasa - Jum'at"; 
    				$pasaran = 2; 
    			}

    			if($cekWeekend == 3 || $cekWeekend == 6){
    				// $pasaran[3] = "Rabu - Sabtu"; 
    				$pasaran = 3;
    			}

    			$data = Target::select("*")
    			->whereMonth('tanggal',$bulan)
    			->where('cabang_id', auth()->user()->cabang_id)
    			// ->where('pasaran', $pasaran)
    			->orderBy('created_at', 'desc')
    			->get()
    			->unique('resort_id')
    			;
    			
    			return view('backend.target.table', compact('getTanggal','data'));
    		}    		

    	}
    	// dd('dd');
    	$today =  date('Y-m-d');
    	$resort = Resort::get();

    	$cekWeekend = date('w', strtotime($today));
    	
    	$pasaran =  [];

    	if($cekWeekend == 1 || $cekWeekend == 4){
    		$pasaran[1] = "Senin - Kamis"; 
    	}

    	if($cekWeekend == 2 || $cekWeekend == 5){
    		$pasaran[2] = "Selasa - Jum'at"; 
    	}

    	if($cekWeekend == 3 || $cekWeekend == 6){
    		$pasaran[3] = "Rabu - Sabtu"; 
    	}
    	return view('backend.target.index', compact('today', 'resort','pasaran' ));
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
    		->first();
    		$cekTarget = Target::where('pasaran', $request->pasaran)
    		->where('resort_id',$request->resort_id)
    		->first();
    		$cekDropLalu = Target::where('resort_id',$request->resort_id)
    		->latest()
    		->first();

    		$target['cabang_id'] = auth()->user()->cabang_id; 
    		$target['created_by'] = auth()->user()->id; 

    		if(empty($cekTarget)){
    			if(empty($anggota)){
    				toastr()->warning('Silahkan Input Data Master Anggota Terlebih Dahulu!', 'Perhatian');
    				return back();
    			}
    			$target['anggota_lalu'] = $anggota->anggota;
    		}else{
    			$target['anggota_lalu'] = $cekTarget->anggota_kini;
    		}
    		$target['anggota_kini'] = $target['anggota_lalu'] + $target['anggota_lama'] + $target['anggota_baru'] - $target['anggota_out'];

    		if(!empty($cekDropLalu)){
    			$target['target_lalu'] = $cekDropLalu->target_kini;
    		}else{
    			$target['target_lalu'] = 0;
    		}
    		$target['target_20_drop'] = ($request->target_drops * 20) / 100;
    		$target['target_20_plnsn'] = ($request->target_plnsn * 20) / 100;
    		$target['target_kini'] = $target['target_lalu'] + $target['target_20_drop']  - $target['target_20_plnsn'];
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
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
        //
    }
}
