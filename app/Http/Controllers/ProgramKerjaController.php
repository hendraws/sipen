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
    		$data = ProgramKerja::with('Cabang')->get();
    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('cabang', function ($row) {
    			$cabang = $row->Cabang->cabang;
    			return $cabang;
    		})     		
    		->addColumn('tanggal', function ($row) {
    			$tanggal = date('d-m-Y', strtotime($row->tanggal));
    			return $tanggal;
    		})     	
    		->addColumn('drop', function ($row) {
    			$drop = $row->drops;
    			return $drop;
    		})         		
    		->addColumn('storting', function ($row) {
    			$storting = $row->storting;
    			return $storting;
    		})     	
    		->addColumn('psp', function ($row) {
    			$psp = $row->psp;
    			return $psp;
    		})         		
    		->addColumn('drop_tunda', function ($row) {
    			$drop_tunda = $row->drop_tunda;
    			return $drop_tunda;
    		})         		
    		->addColumn('storting_tunda', function ($row) {
    			$storting_tunda = $row->storting_tunda;
    			return $storting_tunda;
    		})         		
    		->addColumn('tkp', function ($row) {
    			$tkp = $row->tkp;
    			return $tkp;
    		})         		
    		->addColumn('sisa_kas', function ($row) {
    			$sisa_kas = $row->sisa_kas;
    			return $sisa_kas;
    		})     
    		->addColumn('created_by', function ($row) {
    			$created_by = $row->DibuatOleh->name;
    			return $created_by;
    		})     
    		->addColumn('updated_by', function ($row) {
    			$updated_by = $row->DieditOleh->name;
    			return $updated_by;
    		})     
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-xs btn-warning" href="'. action('ProgramKerjaController@edit', $row->id) .'" >Edit</a>';
    			$action = $action .  '<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ProgramKerjaController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>';
    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
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

    	DB::beginTransaction();
    	try {
    		ProgramKerja::Create(
    			[
    				"cabang" => $request->cabang,
    				"tanggal" => $request->tanggal,
    				"drops" => $request->drop,
    				"storting" => $request->storting,
    				"psp" => $request->psp,
    				"drop_tunda" => $request->drop_tunda,
    				"storting_tunda" => $request->storting_tunda,
    				"tkp" => $request->tkp,
    				"sisa_kas" => $request->sisa_kas,
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
    			"psp" => $request->psp,
    			"drop_tunda" => $request->drop_tunda,
    			"storting_tunda" => $request->storting_tunda,
    			"tkp" => $request->tkp,
    			"sisa_kas" => $request->sisa_kas,
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
