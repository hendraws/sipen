<?php

namespace App\Http\Controllers;

use App\AngsuranKemacetan;
use App\Kemacetan;
use App\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AngsuranKemacetanController extends Controller
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
    		$data = AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->orderBy('tanggal')
    		->get();
    		
    		$kemacetan = Kemacetan::leftjoin('angsuran_kemacetans','angsuran_kemacetans.kemacetan_id', 'kemacetans.id' )
    		->whereMonth('kemacetans.tanggal',$bulan )
    		->where('kemacetans.cabang_id', auth()->user()->cabang_id)
    		->where('kemacetans.resort_id', $request->resort)
    		->select('kemacetans.pasaran as pasaran', 'ma_saldo','mb_saldo','angsuran')
    		->orderBy('kemacetans.pasaran')
    		->get();

    		$totalAngsuran =  AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('count(tanggal) as hk, sum(angsuran) as total_angsuran')
    		->first();

    		$totalKemacetan = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('sum(ma_saldo) as total_ma_saldo ,sum(mb_saldo) as total_mb_saldo')
    		->first();
    		// dd($totalKemacetan);
    		return view('backend.angsuran_kemacetan.table', compact('data', 'getTanggal','kemacetan', 'totalAngsuran', 'totalKemacetan'));
    	}

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
    	return view('backend.angsuran_kemacetan.index',compact('today','resort','pasaran'));
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

    	$angsuran = $request->validate([
    		'resort_id' => 'required',
    		'pasaran' => 'required',
    		'anggota_keluar' => 'required',
    		'angsuran' => 'required',
    		'tanggal' => 'required',
    	]);

    	DB::beginTransaction();
    	try {

    		$kemacetan = Kemacetan::where('resort_id', $request->resort_id)->where('cabang_id', auth()->user()->cabang_id)->where('pasaran', $request->pasaran)->first();

    		$angsuran['kemacetan_id'] = $kemacetan->id; 
    		$angsuran['cabang_id'] = auth()->user()->cabang_id; 
    		$angsuran['created_by'] = auth()->user()->id; 

    		$cekAngsuran  = AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->where('tanggal', $request->tanggal)
    		->first();

    		if(!empty($cekAngsuran)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		AngsuranKemacetan::create($angsuran);
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
     * @param  \App\AngsuranKemacetan  $angsuranKemacetan
     * @return \Illuminate\Http\Response
     */
    public function show(AngsuranKemacetan $angsuranKemacetan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AngsuranKemacetan  $angsuranKemacetan
     * @return \Illuminate\Http\Response
     */
    public function edit(AngsuranKemacetan $angsuranKemacetan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AngsuranKemacetan  $angsuranKemacetan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AngsuranKemacetan $angsuranKemacetan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AngsuranKemacetan  $angsuranKemacetan
     * @return \Illuminate\Http\Response
     */
    public function destroy(AngsuranKemacetan $angsuranKemacetan)
    {
        //
    }
}