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
    		$data = ProgramKerja::with('Cabang')
    		->whereMonth('tanggal',date('m'))
    		->whereYear('tanggal',date('Y'))
    		->orderBy('tanggal','desc');
    		return Datatables::of($data)
    		->addIndexColumn()

    		->addColumn('cabang', function ($row) {
    			$cabang = $row->Cabang->cabang;
    			return $cabang;
    		})    
    		->addColumn('drop', function ($row) {
    			$drop = number_format($row->drops);
    			return $drop;
    		})         		
    		->addColumn('storting', function ($row) {
    			$storting = number_format($row->storting);
    			return $storting;
    		})     	
    		->addColumn('tkp', function ($row) {
    			$tkp = number_format($row->tkp);
    			return $tkp;
    		})         		     		
    		->addColumn('drop_tunda', function ($row) {
    			$drop_tunda = number_format($row->drop_tunda);
    			return $drop_tunda;
    		})         		
    		->addColumn('storting_tunda', function ($row) {
    			$storting_tunda = number_format($row->storting_tunda);
    			return $storting_tunda;
    		})         		
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-xs btn-warning" href="'. action('ProgramKerjaController@edit', $row->id) .'" >Edit</a>';
    			$action = $action .  '<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ProgramKerjaController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Reset</a>';
    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
    	}
    	$globalData = ProgramKerja::selectRaw('sum(drops) as sum_drop, 
			    		sum(psp) as sum_psp,
			    		sum(storting) as sum_storting,
			    		sum(drop_tunda) as sum_drop_tunda, 
			    		sum(storting_tunda) as sum_storting_tunda, 
			    		sum(tkp) as sum_tkp')
			    	->whereMonth('tanggal',date('m'))
			    	->whereYear('tanggal',date('Y'))
			    	->first();
    	return view('backend.program_kerja.index', compact('globalData'));
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
    		// 'tanggal' => 'required',
    	]);

    	$cek = ProgramKerja::where('cabang',$request->cabang)->whereMonth('tanggal', date('m'))->first();
    	if(!empty($cek)){
    			toastr()->warning('Data Sudah Ada, Silahkan menggunakan fitur Edit', 'Peringatan');
		    	return redirect(action('ProgramKerjaController@index'));
    	}
    	DB::beginTransaction();
    	try {
    		ProgramKerja::Create(
    			[
    				"cabang" => $request->cabang,
    				// "tanggal" => $request->tanggal,
    				"tanggal" => date('Y-m-d'),
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
    	$request->validate([
    		'tanggal' => 'required',
    		'cabang' => 'required',
    	]);

    	DB::beginTransaction();
    	try {
    		ProgramKerja::whereId($id)->update([
    			"cabang" => $request->cabang,
    			"tanggal" => $request->tanggal,
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


    public function delete($id)
    {
    	$data = ProgramKerja::find($id);
    	return view('backend.program_kerja.delete', compact('data'));
    }
}
