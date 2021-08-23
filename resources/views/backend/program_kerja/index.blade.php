@extends('layouts.app_master')
@section('title', 'Program Kerja')
@section('content-title', 'Program Kerja')
@section('css')
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<style type="text/css">
	.table thead th {
		text-align: center;
		vertical-align: middle;
	}

	table tr th {
		text-align: center;
		vertical-align: middle;
	}	
	table tr td {
		text-align: right;
		vertical-align: middle;
	}
</style>
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('body').addClass('sidebar-mini sidebar-collapse');

		function reloadData() {
			$('#data-table').DataTable().ajax.reload();
		}

		let table = $('#data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ url()->full() }}",
			pageLength: 25,
			responsive: true,
			autoWidth : false,
			// scrollX: "100%",
			scrollCollapse:false,
			columnDefs: [
			{targets: [7], className: "text-center"},
			{targets: [0,1], className: "text-left"},
			{targets: [2,3,4,5,6], className: "text-right"},
			{targets: 0, width: "10px"},
			],
			columns: [

			{"data": 'DT_RowIndex',
			orderable: false, 
			searchable: false},
			 {data: 'cabang', name: 'cabang'},
			 {data: 'drop', name: 'drop'},
			 {data: 'storting', name: 'storting'},
			 {data: 'tkp', name: 'tkp'},
			 {data: 'drop_tunda', name: 'drop_tunda'},
			 {data: 'storting_tunda', name: 'storting_tunda'},
			 {data: 'action', name: 'action', orderable: false, searchable: false},
			 ]
			});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header">
		{{-- <a class="btn btn-sm btn-primary modal-button float-right" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KantorCabangController@create') }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Tambah Data</a> --}}
		<a href="{{ action('ProgramKerjaController@create') }}" class="btn btn-primary btn-sm mr-auto">Tambah Data</a>
		<a href="{{ action('ProgramKerjaController@create') }}" class="btn btn-success btn-sm float-right"><i class="fa fa-print mr-2"></i> Cetak</a>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="data-table" class="table table-bordered table-striped table-sm">
				<thead>
					<tr>
						<th rowspan="2" class="text-center">No</th>
						<th rowspan="2">Kantor Cabang</th>
						<th colspan="5">Program Kerja</th>
						<th rowspan="2">Aksi</th>
					</tr>
					<tr>
						<th>Drop</th>
						<th>Storting</th>
						<th>TKP</th>
						<th>Drop Tunda</th>
						<th>Storting Tunda</th>
					</tr>
				</thead>
			</table>
		</div>		
	</div>
	<div class="card-footer">
		<table class="table table-bordered table-striped table-sm">
			<tr>
				<th colspan="2" rowspan="2" style="		vertical-align: middle;">Rencana Kerja Global</th>
				<th>Drop</th>
				<th>Storting</th>
				<th>TKP</th>
				<th>Drop Tunda</th>
				<th>Storting Tunda</th>
			</tr>
			<tr>
				<td>{{ number_format($globalData->sum_drop) }}</td>
				<td>{{ number_format($globalData->sum_storting) }}</td>
				<td>{{ number_format($globalData->sum_tkp) }}</td>
				<td>{{ number_format($globalData->sum_drop_tunda) }}</td>
				<td>{{ number_format($globalData->sum_storting_tunda) }}</td>
			</tr>
		</table>

	</div>
</div>

@endsection
