@extends('layouts.app_master')
@section('title', 'Anggota Lalu ')
@section('content-title', 'Anggota Lalu Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function () {
		$("#bulan").datepicker( {
			format: "yyyy/mm",
			startView: "months", 
			minViewMode: "months"
		});
	});
	
	$(document).on('click', '#filter', function(){
		var resort = $('#resort_id').val();
		var tanggal = $('#bulan').val();
		var url = "{{ url()->current() }}?tanggal="+tanggal+"&resort="+resort;
		if(resort == null){
			return Swal.fire({title: 'Pilih Resort Terlebih dahulu', icon: 'warning', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		}
		getDataTable(url, '#data-table')
	});
</script>
@endsection

@section('content')
<div class="card card-outline card-primary collapsed-card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-4">
				<h3 class="card-title">Input Data</h3>
			</div>
			<div class="col-md-3">
				<select class="form-control" name="resort_id" id="resort_id">
					<option disabled="" selected>Pilih Resort</option>
					@foreach ($resort as $row)
					<option value="{{ $row->id }}" >{{ $row->nama }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-5 ml-auto">
				
				<div class="input-group mb-3 input-sm">
					<input type="text" class="form-control input-sm " placeholder="Pilih Bulan" readonly="" id="bulan" value="{{ date('Y/m') }}">
					<button class="btn btn-outline-info ml-2" type="button" id="filter">Filter</button>
					{{-- <a href="" class="btn btn-success  mx-2 float-right" target="_blank">Cetak</a> --}}
					<div class="card-tools ml-2">
						<button type="button" class="btn btn-primary" data-card-widget="collapse">Tambah
						</button>
					</div>
				</div>
			</div>
		</div>



		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body" style="display: none;">
		@includeIf('backend.anggota_lalu.create')
	</div>
	<!-- /.card-body -->
</div>

<div id="data-table"></div>

@endsection
