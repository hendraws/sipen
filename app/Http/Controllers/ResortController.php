<?php

namespace App\Http\Controllers;

use App\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ResortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if ($request->ajax()) {
    		$data = Resort::when(auth()->user()->hasRole('user'), function($q){
    			$q->where('cabang_id', auth()->user()->cabang_id);
    		})->get();
    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('nama', function ($row) {
    			$nama = $row->nama;
    			return $nama;
    		})     
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-warning btn-sm modal-button" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ResortController@edit',$row).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Edit</a>';
    			$action = $action .  '<a class="btn btn-sm btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ResortController@delete',$row).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>';

    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
    	}

    	return view('backend.resort.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('backend.resort.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// dd(auth()->user());
    	$request->validate([
    		'nama' => 'required|max:255',
    	]);

    	DB::beginTransaction();
    	try {
    		Resort::Create(
    			[
    				'cabang_id' => auth()->user()->cabang_id,
    				'nama' => $request->nama,
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
     * @param  \App\Resort  $resort
     * @return \Illuminate\Http\Response
     */
    public function show(Resort $resort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resort  $resort
     * @return \Illuminate\Http\Response
     */
    public function edit(Resort $resort)
    {

    	return view('backend.resort.edit', compact('resort'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resort  $resort
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resort $resort)
    {
    	$request->validate([
    		'nama' => 'required|max:255',
    	]);

    	DB::beginTransaction();
    	try {
    		$resort->update([
    			'nama' => $request->nama,
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
     * @param  \App\Resort  $resort
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resort $resort)
    {
    	$resort->delete();
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }

    public function delete(Resort $resort)
    {

    	return view('backend.resort.delete', compact('resort'));
    }
}
