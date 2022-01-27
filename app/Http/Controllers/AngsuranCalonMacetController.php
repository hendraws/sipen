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

    		$calonMacet = CalonMacet::leftjoin('angsuran_calon_macets','angsuran_calon_macets.calon_macet_id', 'calon_macets.id' )
    		->whereMonth('calon_macets.tanggal',$bulan )
    		->where('calon_macets.cabang_id', auth()->user()->cabang_id)
    		->where('calon_macets.resort_id', $request->resort)
    		->selectRaw('calon_macets.pasaran as pasaran, cma_saldo as cma_saldo,angsuran as angsuran, cma_anggota as cma_anggota, sum(anggota_keluar) as anggota_keluar')
    		->orderBy('calon_macets.pasaran')
    		->groupBy('calon_macets.pasaran')
    		->get();
				// <th scope="col" >Hari Kerja</th>
				// 				<th scope="col" >Anggota</th>
				// 				<th scope="col" >Anggota Keluar</th>
				// 				<th scope="col" >Total Anggota</th>
				// 				<th scope="col" >Calon Macet Awal</th>
				// 				<th scope="col" >Angsuran</th>
				// 				<th scope="col" >Saldo</th>
    		$totalAngsuran =  CalonMacet::leftJoin('angsuran_calon_macets','angsuran_calon_macets.calon_macet_id','calon_macets.id' ) 
    		// AngsuranCalonMacet::leftjoin('calon_macets','calon_macets.id','angsuran_calon_macets.calon_macet_id')
    		->where('angsuran_calon_macets.cabang_id', auth()->user()->cabang_id)
    		->where('angsuran_calon_macets.resort_id', $request->resort)
    		->whereMonth('angsuran_calon_macets.tanggal',$bulan)
    		->selectRaw('
    			count(angsuran_calon_macets.tanggal) as hk, 
    			sum(calon_macets.cma_anggota) as total_anggota, 
    			sum(anggota_keluar) as total_anggota_keluar,
    			sum(cma_saldo) as total_cma_saldo, 
    			sum(angsuran) as total_angsuran
    			')
    		->first();
    		// dd($totalAngsuran);
    		$totalKemacetan = CalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $request->resort)
    		->whereMonth('tanggal',$bulan)
    		->selectRaw('sum(cma_saldo) as total_cma_saldo')
    		->first();


    		if($request->has('cetak')){
    		return view('backend.angsuran_calon_macet.cetak', compact('data', 'getTanggal','calonMacet', 'totalAngsuran', 'totalKemacetan'));
    		}

    		return view('backend.angsuran_calon_macet.table', compact('data', 'getTanggal','calonMacet', 'totalAngsuran', 'totalKemacetan'));
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

    		$calonMacet = CalonMacet::where('resort_id', $request->resort_id)
    		->where('cabang_id', auth()->user()->cabang_id)
    		->where('pasaran', $request->pasaran)
			->whereMonth('tanggal', date('m',strtotime($request->tanggal)))
    		->first();

    		if(empty($calonMacet)){
    			toastr()->error('Silahkan membuat data master calon macet terlebih dahulu!');
    			return redirect()->action('CalonMacetController@index');
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
    		$sisa_angsuran = $calonMacet->sisa_angsuran - $request->angsuran; 
    		$calonMacet->update([
    			'sisa_angsuran' => $sisa_angsuran
    		]);

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function show(AngsuranCalonMacet $angsuran_calon_macet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function edit(AngsuranCalonMacet $angsuran_calon_macet)
    {
        $today =  date('Y-m-d');
    	$resort = Resort::when(auth()->user()->hasRole('user'), function($q){
    		$q->where('cabang_id', auth()->user()->cabang_id);
    	})->get();

    	$cekWeekend = date('w', strtotime($angsuran_calon_macet->tanggal));
    	
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
    	// dd($angsuran_calon_macet);
    	return view('backend.angsuran_calon_macet.edit',compact('angsuran_calon_macet', 'resort','today','pasaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AngsuranCalonMacet $angsuran_calon_macet)
    {

        $angsuran = $request->validate([
    		'pasaran' => 'required',
    		'anggota_keluar' => 'required',
    		'angsuran' => 'required',
    		'tanggal' => 'required',
    	]);

    	DB::beginTransaction();
    	try {

    		$calonMacet = CalonMacet::where('resort_id', $angsuran_calon_macet->resort_id)
    		->where('cabang_id', auth()->user()->cabang_id)
    		->where('pasaran', $request->pasaran)
    		->whereMonth('tanggal', date('m',strtotime($request->tanggal)))
    		->first();

    		if(empty($calonMacet)){
    			toastr()->error('Silahkan membuat data master calon macet terlebih dahulu!');
    			return redirect()->action('CalonMacetController@index');
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

    		if(!empty($cekAngsuran) && $request->tanggal != $angsuran_calon_macet->tanggal){
    			toastr()->warning('Data Sudah Ada', 'Error');
    			return back();
    		}
   			$angsuran_calon_macet->update($angsuran);

   			$dataAngsuran = AngsuranCalonMacet::where('cabang_id', auth()->user()->cabang_id)
    		->where('resort_id', $angsuran_calon_macet->resort_id)
    		->where('pasaran', $angsuran_calon_macet->pasaran)
    		->where('calon_macet_id', $angsuran_calon_macet->calon_macet_id)
    		->selectRaw('sum(angsuran) as totalAngsuran')
    		->first();
    		
    		$dataCalonMacet = CalonMacet::find($angsuran_calon_macet->calon_macet_id);
   			
    		$dataCalonMacet->update([
    			'sisa_angsuran' => $dataCalonMacet->total_saldo - $dataAngsuran->totalAngsuran
    		]);
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
    	toastr()->success('Data telah diperbarui', 'Berhasil');
    	return redirect()->action('AngsuranCalonMacetController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AngsuranCalonMacet  $angsuranCalonMacet
     * @return \Illuminate\Http\Response
     */
    public function destroy(AngsuranCalonMacet $angsuran_calon_macet)
    {

        $angsuran_calon_macet->delete();
    	$result['code'] = '200';
    	return response()->json($result);
    }
}
