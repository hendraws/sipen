<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = Report::get();
    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('cabang', function ($row) {
    			$cabang = $row->cabang;
    			return $cabang;
    		})     	
    		->addColumn('drop', function ($row) {
    			$drop = $row->drop;
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
    			$created_by = $row->dibuatOleh->name;
    			return $created_by;
    		})     
    		->addColumn('updated_by', function ($row) {
    			$updated_by = $row->dieditOleh->name;
    			return $updated_by;
    		})     
    		->addColumn('action', function ($row) {
    			$action =  '<a class="btn btn-sm btn-warning modal-button" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('ReportController@edit',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Edit</a>';
    			// $action = $action .  '<a class="btn btn-sm btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('KantorCabangController@delete',$row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>';

    			return $action;
    		})
    		->rawColumns(['action'])
    		->make(true);
    	}

    	return view('backend.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('backend.report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
