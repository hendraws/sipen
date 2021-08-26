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
<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('body').addClass('sidebar-mini sidebar-collapse');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).on('click', '#cetak', function(){
			$('.print').printThis({
				canvas: true,
			});
		});
		$(".tanggal").datepicker( {
			format: "yyyy/mm",
			startView: "months", 
			minViewMode: "months"
		});

		$(document).on('click', '#filter', function(){
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			getGraphic($('.tanggal').val());
		});
		getGraphic("{{ date('Y/m') }}");
	});
	function getGraphic(tanggal){
		$.ajax({
			url: "{{ url()->current() }}?tanggal="+tanggal,
			type: "get",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#data-table").empty().html(data);
			$('[data-toggle="tooltip"]').tooltip();
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header">
		{{-- <a class="btn btn-sm btn-primary modal-button float-right" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KantorCabangController@create') }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Tambah Data</a> --}}
		<div class="row">
			<div class="col-md-4">
				<a href="{{ action('ProgramKerjaController@create') }}" class="btn btn-primary mr-auto">Tambah Data</a>
			</div>
			<div class="col-md-4">
				
			</div>
			<div class="col-md-3 ml-auto">
				
				<div class="input-group mb-3 input-sm">
					<input type="text" class="form-control input-sm tanggal" placeholder="Pilih Bulan" readonly="">
					<div class="input-group-append">
						<button class="btn btn-outline-info" type="button" id="filter">Filter</button>
					</div>
					<a href="{{ action('ProgramKerjaController@print') }}" class="btn btn-success mx-2" target="_blank">Cetak</a>
				</div>
			</div>
		</div>

	</div>
	<div id="data-table"></div>
</div>

@endsection
