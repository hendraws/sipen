<?php

namespace App\Http\Controllers;

use App\Kemacetan;
use App\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KemacetanController extends Controller
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
    		$data = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    				->where('resort_id', $request->resort)
    				->whereMonth('tanggal',$bulan)
    				->get();
    		return view('backend.kemacetan.table', compact('data', 'getTanggal'));
    	}
    	$resort = Resort::get();
    	$today =  date('Y-m-d');
    	return view('backend.kemacetan.index', compact('today', 'resort'));
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
    		'ma_anggota' => 'required',
    		'ma_pinjaman' => 'required',
    		'ma_target' => 'required',
    		'ma_saldo' => 'required',
    		'mb_anggota' => 'required',
    		'mb_pinjaman' => 'required',
    		'mb_target' => 'required',
    		'mb_saldo' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$pasaran['cabang_id'] = auth()->user()->cabang_id; 
    		$pasaran['tanggal'] = date('Y-m-d'); 

    		$cekKemacetan  = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal',now()->month)
    		->first();
    		if(!empty($cekKemacetan)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		Kemacetan::create($pasaran);
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
     * @param  \App\Kemacetan  $kemacetan
     * @return \Illuminate\Http\Response
     */
    public function show(Kemacetan $kemacetan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kemacetan  $kemacetan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kemacetan $kemacetan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kemacetan  $kemacetan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kemacetan $kemacetan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kemacetan  $kemacetan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kemacetan $kemacetan)
    {
        //
    }
}
