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
    		->selectRaw('kemacetans.pasaran as pasaran,sum(ma_saldo) as ma_saldo, sum(mb_saldo) as mb_saldo, sum(angsuran) as angsuran,  ma_anggota,  mb_anggota, sum(anggota_keluar) as anggota_keluar')
    		->orderBy('kemacetans.pasaran')
    		->groupBy('kemacetans.pasaran')
    		->get();
    		// dd($kemacetan);
    		// $totalAngsuran =  AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		// ->where('resort_id', $request->resort)
    		// ->whereMonth('tanggal',$bulan)
    		// ->selectRaw('count(tanggal) as hk, sum(angsuran) as total_angsuran, sum(anggota_keluar) as total_anggota_keluar')
    		// ->first();

    		$totalAngsuran =  AngsuranKemacetan::join('kemacetans','kemacetans.id','angsuran_kemacetans.kemacetan_id')
    		->where('angsuran_kemacetans.cabang_id', auth()->user()->cabang_id)
    		->where('angsuran_kemacetans.resort_id', $request->resort)
    		->whereMonth('angsuran_kemacetans.tanggal',$bulan)
    		->selectRaw('
    			count(angsuran_kemacetans.tanggal) as hk, 
    			sum(angsuran_kemacetans.angsuran) as total_angsuran, 
    			sum(ma_saldo) as total_ma_saldo, 
    			sum(ma_anggota) as ma_anggota, 
    			sum(mb_anggota) as mb_anggota, 
    			sum(ma_saldo) as total_ma_saldo, 
    			sum(mb_saldo) as total_mb_saldo, 
    			sum(anggota_keluar) as total_anggota_keluar
    			')
    		->first();
    		
    		$totalKemacetan = Kemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('sum(ma_saldo) as total_ma_saldo ,sum(mb_saldo) as total_mb_saldo, sum(mb_anggota) as total_mb_anggota, sum(ma_anggota) as total_ma_anggota')
    		->first();

    		if($request->has('cetak')){
    			return view('backend.angsuran_kemacetan.cetak', compact('data', 'getTanggal','kemacetan', 'totalAngsuran', 'totalKemacetan'));
    		}
    		// dd($totalKemacetan);
    		return view('backend.angsuran_kemacetan.table', compact('data', 'getTanggal','kemacetan', 'totalAngsuran', 'totalKemacetan'));
    	}

    	$today =  date('Y-m-d');
    	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		$q->where('cabang_id', auth()->user()->cabang_id);
    	})->get();

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

    		$kemacetan = Kemacetan::where('resort_id', $request->resort_id)
    		->where('cabang_id', auth()->user()->cabang_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal', date('m',strtotime($request->tanggal)))
    		->first();


    		if(empty($kemacetan)){
    			toastr()->warning('Silahkan mengisi data kemacetan terlebih dahulu', 'Error');
    			return redirect()->action('KemacetanController@index');
    		}

    		$angsuran['kemacetan_id'] = $kemacetan->id; 
    		$angsuran['cabang_id'] = auth()->user()->cabang_id; 
    		$angsuran['created_by'] = auth()->user()->id; 

    		$cekAngsuran  = AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->where('tanggal', $request->tanggal)
    		->where('kemacetan_id', $kemacetan->id)
    		->first();

    		if(!empty($cekAngsuran)){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		$sisa_angsuran = $kemacetan->sisa_angsuran - $request->angsuran; 
    		$kemacetan->update([
    			'sisa_angsuran' => $sisa_angsuran
    		]);
    		
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
     * @param  \App\AngsuranKemacetan  $angsuran_kemacetan
     * @return \Illuminate\Http\Response
     */
    public function show(AngsuranKemacetan $angsuran_kemacetan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AngsuranKemacetan  $angsuran_kemacetan
     * @return \Illuminate\Http\Response
     */
    public function edit(AngsuranKemacetan $angsuran_kemacetan)
    {

    	$today =  date('Y-m-d');
    	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		$q->where('cabang_id', auth()->user()->cabang_id);
    	})->get();

    	$cekWeekend = date('w', strtotime($angsuran_kemacetan->tanggal));
    	
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
    	// dd($angsuran_kemacetan);
    	return view('backend.angsuran_kemacetan.edit',compact('angsuran_kemacetan', 'resort','today','pasaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AngsuranKemacetan  $angsuran_kemacetan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AngsuranKemacetan $angsuran_kemacetan)
    {


    	$angsuran = $request->validate([
    		'pasaran' => 'required',
    		'anggota_keluar' => 'required',
    		'angsuran' => 'required',
    		'tanggal' => 'required',
    	]);

    	DB::beginTransaction();
    	try {

    		$kemacetan = Kemacetan::where('resort_id', $angsuran_kemacetan->resort_id)
    		->where('cabang_id', auth()->user()->cabang_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal', date('m',strtotime($request->tanggal)))
    		->first();

    		if(empty($kemacetan)){
    			toastr()->warning('Silahkan mengisi data kemacetan terlebih dahulu', 'Error');
    			return redirect()->action('KemacetanController@index');
    		}

    		$angsuran['kemacetan_id'] = $kemacetan->id; 
    		$angsuran['cabang_id'] = auth()->user()->cabang_id; 
    		$angsuran['created_by'] = auth()->user()->id; 

    		$cekAngsuran  = AngsuranKemacetan::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort_id)
    		->where('pasaran', $request->pasaran)
    		->where('tanggal', $request->tanggal)
    		->where('kemacetan_id', $kemacetan->id)
    		->first();

    		if(!empty($cekAngsuran) && $request->tanggal != $angsuran_kemacetan->tanggal){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
    		$angsuran_kemacetan->update($angsuran);

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
    	return redirect()->action('AngsuranKemacetanController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AngsuranKemacetan  $angsuran_kemacetan
     * @return \Illuminate\Http\Response
     */
    public function destroy(AngsuranKemacetan $angsuran_kemacetan)
    {
    	$angsuran_kemacetan->delete();
    	$result['code'] = '200';
    	return response()->json($result);
    }
}
