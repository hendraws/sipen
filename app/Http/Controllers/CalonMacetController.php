<?php

namespace App\Http\Controllers;

use App\CalonMacet;
use App\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalonMacetController extends Controller
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
    		$data = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->get();
    		
    		return view('backend.calon_macet.table', compact('data', 'getTanggal'));
    	}
    	$resort = Resort::get();
    	$today =  date('Y-m-d');
    	return view('backend.calon_macet.index', compact('today', 'resort'));
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
    		'cma_anggota' => 'required',
    		'cma_pinjaman' => 'required',
    		'cma_target' => 'required',
    		'cma_saldo' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$pasaran['cabang_id'] = auth()->user()->cabang_id; 
    		$pasaran['tanggal'] = date('Y-m-d'); 
    		$pasaran['created_by'] = auth()->user()->id; 
    		$pasaran['total_saldo'] = $request->cma_saldo; 
    		$pasaran['sisa_angsuran'] = $request->cma_saldo; 
    		
    		$cekKemacetan  = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal',now()->month)
    		->first();
    		if(!empty($cekKemacetan)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
			CalonMacet::create($pasaran);
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
     * @param  \App\CalonMacet  $calonMacet
     * @return \Illuminate\Http\Response
     */
    public function show(CalonMacet $calonMacet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CalonMacet  $calonMacet
     * @return \Illuminate\Http\Response
     */
    public function edit(CalonMacet $calonMacet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CalonMacet  $calonMacet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalonMacet $calonMacet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CalonMacet  $calonMacet
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalonMacet $calonMacet)
    {
        //
    }
}
