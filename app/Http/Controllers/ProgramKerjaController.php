<?php

namespace App\Http\Controllers;

use App\KantorCabang;
use App\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	

    	

    	if ($request->ajax()) {
    		$pecah = explode( '/',$request->tanggal);

    		$getTanggal = $request->tanggal."/01";
    		$tahun = $pecah[0];
    		$bulan = $pecah[1];

    		$data = ProgramKerja::with('Cabang')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->orderBy('tanggal','desc')
    		->get();

    		$globalData = ProgramKerja::selectRaw('sum(drops) as sum_drop, 
    			sum(psp) as sum_psp,
    			sum(storting) as sum_storting,
    			sum(drop_tunda) as sum_drop_tunda, 
    			sum(storting_tunda) as sum_storting_tunda, 
    			sum(tkp) as sum_tkp')
    		->whereMonth('tanggal',$bulan)
    		->whereYear('tanggal',$tahun)
    		->first();
    		return view('backend.program_kerja.table', compact('globalData', 'data','getTanggal'));
    	}
    	return view('backend.program_kerja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$today =  date('Y-m-d');
    	$cabang  = KantorCabang::pluck('cabang','id');
    	return view('backend.program_kerja.create', compact('cabang','today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'cabang' => 'required',
    		'tanggal' => 'required',
    	]);
    	$pecah = explode( '/',$request->tanggal);

    	$tanggal = $request->tanggal."/01";
    	$tahun = $pecah[0];
    	$bulan = $pecah[1];

    	$cek = ProgramKerja::where('cabang',$request->cabang)
    	->whereMonth('tanggal', $bulan)
    	->whereYear('tanggal', $tahun)
    	->first();

    	if(!empty($cek)){
    		toastr()->warning('Data Sudah Ada, Silahkan menggunakan fitur Edit', 'Peringatan');
    		return redirect(action('ProgramKerjaController@index'));
    	}
    	DB::beginTransaction();
    	try {
    		ProgramKerja::Create(
    			[
    				"cabang" => $request->cabang,
    				"tanggal" => $tanggal,
    				"drops" => $request->drop,
    				"storting" => $request->storting,
    				"psp" => 0,
    				"drop_tunda" => $request->drop_tunda,
    				"storting_tunda" => $request->storting_tunda,
    				"tkp" => $request->tkp,
    				"sisa_kas" => 0,
    				'created_by' => auth()->user()->id,
    				'updated_by' => auth()->user()->id,
    			]
    		);

    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah ditambahkan', 'Berhasil');
    	return redirect(action('ProgramKerjaController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramKerja $programKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$today =  date('Y-m-d');
    	$cabang  = KantorCabang::pluck('cabang','id');
    	$data  = ProgramKerja::find($id);
    	return view('backend.program_kerja.edit', compact('data', 'today','cabang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	
    	DB::beginTransaction();
    	try {
    		ProgramKerja::whereId($id)->update([
    			// "cabang" => $request->cabang,
    			// "tanggal" => $request->tanggal,
    			"drops" => $request->drop,
    			"storting" => $request->storting,
    			"psp" => 0,
    			"drop_tunda" => $request->drop_tunda,
    			"storting_tunda" => $request->storting_tunda,
    			"tkp" => $request->tkp,
    			"sisa_kas" => 0,
    			'updated_by' => auth()->user()->id,
    		]);

    	} catch (\Exception $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		return back();
    	}catch (\Throwable $e) {
    		DB::rollback();
    		toastr()->success($e->getMessage(), 'Error');
    		throw $e;
    	}

    	DB::commit();
    	toastr()->success('Data telah Diubah', 'Berhasil');
    	return redirect(action('ProgramKerjaController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$data = ProgramKerja::find($id);
    	$data->updated_by = auth()->user()->id;
    	$data->save();
    	$data->delete();
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }    
    public function reset($id)
    {
    	$data = ProgramKerja::find($id);
    	$data->drops = 0;
    	$data->storting = 0;
    	$data->psp = 0;
    	$data->tkp = 0;
    	$data->drop_tunda = 0;
    	$data->storting_tunda = 0;
    	$data->updated_by = auth()->user()->id;
    	$data->save();
    	toastr()->success('Data telah reset', 'Berhasil');
    	return back();
    }


    public function delete($id)
    {
    	$data = ProgramKerja::find($id);
    	return view('backend.program_kerja.delete', compact('data'));
    }    
    public function resetModal($id)
    {
    	$data = ProgramKerja::find($id);
    	return view('backend.program_kerja.reset_modal', compact('data'));
    }

    public function print()
    {
    	$data = ProgramKerja::with('Cabang')->get();
    	return view('backend.program_kerja.print', compact('data'));

    }
}
