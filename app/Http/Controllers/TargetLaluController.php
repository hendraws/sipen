<?php

namespace App\Http\Controllers;

use App\Resort;
use App\Target;
use App\TargetLalu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetLaluController extends Controller
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
    		$data = TargetLalu::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->get();

    		return view('backend.target_lalu.table', compact('data', 'getTanggal'));
    	}
    	$resort = Resort::get();
    	$today =  date('Y-m-d');
    	return view('backend.target_lalu.index', compact('today', 'resort'));
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
    	$pasaran = $request->validate([
    		'resort_id' => 'required',
    		'pasaran' => 'required',
    		'target_lalu' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$pasaran['cabang_id'] = auth()->user()->cabang_id; 
    		$pasaran['tanggal'] = date('Y-m-d'); 

    		$cekKemacetan  = TargetLalu::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal', date('m'))
    		->first();
    		
    		if(!empty($cekKemacetan)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		TargetLalu::create($pasaran);
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
     * @param  \App\TargetLalu  $Target_lalu
     * @return \Illuminate\Http\Response
     */
    public function show(TargetLalu $Target_lalu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TargetLalu  $Target_lalu
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetLalu $Target_lalu)
    {
    	return view('backend.target_lalu.edit', compact('Target_lalu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TargetLalu  $Target_lalu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TargetLalu $Target_lalu)
    {
    	DB::beginTransaction();
    	try {
    		$Target_lalu->update(['target_lalu' => $request->target_lalu]);

    		$bulan = date('m', strtotime($Target_lalu->tanggal));
    		$target = Target::where('pasaran',$Target_lalu->pasaran)
    		->where('resort_id', $Target_lalu->resort_id)
    		->orderBy('tanggal','asc')
    		->first();
    		if(!empty($target)){
    			$target->update(['target_lalu' => $request->target_lalu]);
    		}
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
    	return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TargetLalu  $Target_lalu
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetLalu $Target_lalu)
    {
    	$Target_lalu->delete();

    	$target =  Target::where('pasaran',$Target_lalu->pasaran)
    		->where('resort_id', $Target_lalu->resort_id)
    		->delete();

    	$result['code'] = '200';
    	return response()->json($result);
    }
}
