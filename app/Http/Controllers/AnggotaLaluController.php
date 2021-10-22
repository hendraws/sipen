<?php

namespace App\Http\Controllers;

use App\AnggotaLalu;
use App\Resort;
use App\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaLaluController extends Controller
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
    		$data = AnggotaLalu::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->get();

    		return view('backend.anggota_lalu.table', compact('data', 'getTanggal'));
    	}
    	$resort = Resort::get();
    	$today =  date('Y-m-d');
    	return view('backend.anggota_lalu.index', compact('today', 'resort'));
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
    		'anggota' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		$pasaran['cabang_id'] = auth()->user()->cabang_id; 
    		$pasaran['tanggal'] = date('Y-m-d'); 

    		$cekKemacetan  = AnggotaLalu::where('cabang_id', auth()->user()->cabang_id)->where('resort_id', $request->resort_id)->where('pasaran', $request->pasaran)->first();
    		
    		if(!empty($cekKemacetan)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		AnggotaLalu::create($pasaran);
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
     * @param  \App\AnggotaLalu  $anggotaLalu
     * @return \Illuminate\Http\Response
     */
    public function show(AnggotaLalu $anggotaLalu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnggotaLalu  $anggotaLalu
     * @return \Illuminate\Http\Response
     */
    public function edit(AnggotaLalu $anggotaLalu)
    {

    	return view('backend.anggota_lalu.edit', compact('anggotaLalu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnggotaLalu  $anggotaLalu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnggotaLalu $anggotaLalu)
    {

    	DB::beginTransaction();
    	try {
    		$anggotaLalu->update(['anggota' => $request->anggota]);

    		$bulan = date('m', strtotime($anggotaLalu->tanggal));
    		$target = Target::where('pasaran',$anggotaLalu->pasaran)
    		->where('resort_id', $anggotaLalu->resort_id)
    		->orderBy('tanggal','asc')
    		->first();
    		$target->update(['anggota_lalu' => $request->anggota]);
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
     * @param  \App\AnggotaLalu  $anggotaLalu
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnggotaLalu $anggotaLalu)
    {
    	$anggotaLalu->delete();

    	$target =  Target::where('pasaran',$anggotaLalu->pasaran)
    		->where('resort_id', $anggotaLalu->resort_id)
    		->delete();
    		
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }

    public function delete(AnggotaLalu $anggotaLalu)
    {
    	return view('backend.anggota_lalu.delete', compact('anggotaLalu'));
    }
}
