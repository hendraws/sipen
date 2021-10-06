<?php

namespace App\Http\Controllers;

use App\AngsuranCalonMacet;
use App\CalonMacet;
use App\Kemacetan;
use App\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    		->select('calon_macets.pasaran as pasaran', 'cma_saldo','angsuran', 'cma_anggota', 'anggota_keluar')
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
    	$angsuran = $request->validate([
    		'resort_id' => 'required',
    		'pasaran' => 'required',
    		'anggota_keluar' => 'required',
    		'angsuran' => 'required',
    		'tanggal' => 'required',
    	]);

    	DB::beginTransaction();
    	try {

    		$calonMacet = CalonMacet::where('resort_id', $request->resort_id)->where('cabang_id', auth()->user()->cabang_id)->where('pasaran', $request->pasaran)->first();
    		if(empty($calonMacet)){
    			toastr()->error('Silahkan membuat data master calon macet terlebih dahulu!');
    			return back();
    		}

    		$angsuran['calon_macet_id'] = $calonMacet->id; 
    		$angsuran['cabang_id'] = auth()->user()->cabang_id; 
    		$angsuran['created_by'] = auth()->user()->id; 

    		$cekAngsuran  = AngsuranCalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->where('tanggal', $request->tanggal)
    		->where('calon_macet_id', $calonMacet->id)
    		->first();

    		if(!empty($cekAngsuran)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		AngsuranCalonMacet::create($angsuran);
    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		// dd($e->getMessage());
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->error($e->getMessage(), 'Error');
    		// dd($e->getMessage());
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah ditambahkan', 'Berhasil');
    	return back();

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
