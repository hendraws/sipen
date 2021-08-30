<?php

namespace App\Http\Controllers;

use App\KantorCabang;
use App\Perkembangan;
use App\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class KantorCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if ($request->ajax()) {
    		$data = KantorCabang::get();
    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('cabang', function ($row) {
    			$cabang = $row->cabang;
    			return $cabang;
    		})     
    		->addColumn('created_by', function ($row) {
    			$created_by = $row->dibuatOleh->name;
    			return $created_by;
    		})     
    		->addColumn('updated_by', function ($row) {
    			$updated_by = $row->dieditOleh->name;
    			return $updated_by;
    		})     
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-sm btn-warning modal-button" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('KantorCabangController@edit',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Edit</a>';
    			$action = $action .  '<a class="btn btn-sm btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('KantorCabangController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>';

    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
    	}

    	return view('backend.kantor_cabang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
    	return view('backend.kantor_cabang.create');
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
    		'cabang' => 'required|unique:kantor_cabangs|max:255',
    	]);

    	DB::beginTransaction();
    	try {
    		KantorCabang::Create(
    			[
    				'cabang' => $request->cabang,
    				'slug' => Str::slug($request->cabang),
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
    	return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KantorCabang  $kantorCabang
     * @return \Illuminate\Http\Response
     */
    public function show(KantorCabang $kantorCabang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KantorCabang  $kantorCabang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data = KantorCabang::find($id);
    	return view('backend.kantor_cabang.edit', compact('data'))->with('title_modal', 'Edit Kantor Cabang');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KantorCabang  $kantorCabang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$request->validate([
    		'cabang' => 'required|unique:kantor_cabangs|max:255',
    	]);

    	DB::beginTransaction();
    	try {
    		KantorCabang::whereId($id)->update([
    			'cabang' => $request->cabang,
    			'slug' => Str::slug($request->cabang),
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
    	return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KantorCabang  $kantorCabang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$data = KantorCabang::find($id);
    	$programKerja = ProgramKerja::where('cabang', $id)->delete();
    	$perkembangan = Perkembangan::where('cabang', $id)->delete();
    	$data->delete();
		toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }

    public function delete($id)
    {
    	$data = KantorCabang::find($id);
    	return view('backend.kantor_cabang.delete', compact('data'));
    }

    public function print()
    {
    	$data = KantorCabang::get();

    	return view('backend.kantor_cabang.print', compact('data'));
    }
}
