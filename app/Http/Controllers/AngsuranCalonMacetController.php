<?php

namespace App\Http\Controllers;

use App\AngsuranCalonMacet;
use App\CalonMacet;
use App\Resort;
use Illuminate\Http\Request;

class AngsuranCalonMacetController extends Controller
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
    		$data = AngsuranCalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->get();
    		
    		$kemacetan = CalonMacet::leftjoin('angsuran_calon_macets','angsuran_calon_macets.calon_macet_id', 'calon_macets.id' )
    		->whereMonth('calon_macets.tanggal',$bulan )
    		->where('calon_macets.cabang_id', auth()->user()->cabang_id)
    		->where('calon_macets.resort_id', $request->resort)
    		->select('calon_macets.pasaran as pasaran', 'cma_saldo','angsuran')
    		->orderBy('calon_macets.pasaran')
    		->get();

    		$totalAngsuran =  AngsuranCalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('count(tanggal) as hk, sum(angsuran) as total_angsuran')
    		->first();

    		$totalKemacetan = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('sum(cma_saldo) as total_cma_saldo')
    		->first();

    		return view('backend.angsuran_calon_macet.table', compact('data', 'getTanggal','kemacetan', 'totalAngsuran', 'totalKemacetan'));
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
    	return view('backend.angsuran_calon_macet.index',compact('today','resort','pasaran'));
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function show(AngsuranCalonMacet $angsuranCalonMacet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function edit(AngsuranCalonMacet $angsuranCalonMacet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AngsuranCalonMacet $angsuranCalonMacet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function destroy(AngsuranCalonMacet $angsuranCalonMacet)
    {
        //
    }
}
