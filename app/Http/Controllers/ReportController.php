<?php

namespace App\Http\Controllers;

use App\KantorCabang;
use App\ProgramKerja;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
	public function perkembangan()
	{
		$data = ProgramKerja::whereIn(DB::raw('MONTH(tanggal)'),['07','08'])->get();

		return view('backend.perkembangan.index');
		return $data;
		return Carbon::now()->subMonth(12)->format('m');
		
	}
}
