@extends('layouts.app_master')
@section('title', 'Management User')
@section('content-title', 'Management User')
@section('css')
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {

		function reloadData() {
			$('.table').DataTable().ajax.reload();
		}

		let table = $('.table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ url()->full() }}",
			pageLength: 25,
			autoWidth: false,
			scrollX: "100%",
			scrollCollapse:false,
			columnDefs: [
			{targets: [0,2,3,], className: "text-center",},
			{targets: 0, width: "15px"},
			],
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, title: '#'},
				{data: 'name', name: 'name', title: 'NAMA'},
				{data: 'cabang', name: 'cabang', title: 'CABANG'},
				{data: 'role', name: 'role', title: 'ROLE'},
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
	<div class="card-header row">
		<a class="btn btn-sm btn-primary ml-auto" href="{{ action('UserController@create') }}"  >Tambah Data</a>
		{{-- <a href="{{ action('KantorCabangController@create') }}" class="btn btn-primary float-right">Tambah Data</a> --}}
	</div>
	<div class="card-body">
		<table id="data-table" class="table table-bordered table-striped">
		</table>
	</div>
</div>

@endsection
