@extends('layouts.app_master')
@section('title', 'Perkembangan')
@section('content-title', 'Informasi Perkembangan KSP Satria Mulia Arthomoro')
@section('css')
<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script type="text/javascript">
	$('body').addClass('sidebar-mini sidebar-collapse');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(".tanggal").datepicker( {
		format: "yyyy/mm",
		startView: "months", 
		minViewMode: "months"
	});

	function number_format(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}
	function getData(cabang, print = false,tanggal,target){
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		$.ajax({
			{{-- url: "{{ url()->current() }}?startdate="+startDate+"&enddate="+endDate+"&graphic="+target, --}}
			url: "{{ url()->current() }}?cabang="+cabang+"&print="+print+"&tanggal="+tanggal,
			type: "post",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#"+target).empty().html(data);
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}
	
	$(document).ready(function () {
		$('#cabang').on('change', function() {
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			getData(this.value, false, $('#tanggal').val(),'dataCabang');
		});	
		if($('#cabang').val().length != 0)
		{
			getData($('#cabang').val(),false, $('#tanggal').val(), 'dataCabang');
		}


		$(document).on('click', '#filter', function(){
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			getData($('#cabang').val(),false, $('#tanggal').val(),'dataCabang');
		});

		$(document).on('click', '#cetak', function(){
			if($('.tanggal').val() === ''){
				return Swal.fire({title: ' Silahkan Pilih Bulan terlebih dahulu', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			}
			getData($('#cabang').val(),true, $('#tanggal').val(), 'allprint');
		});

	});
</script>
@endsection
@section('content')
<div id="allprint">
	<div class="card card-primary card-outline">
		<div class="card-header row">
			<div class="col-md-8">
				<div class="form-group row">
					<label for="tanggal" class="col-sm-2 col-form-label">Pilih Cabang</label>
					<div class="col-md-6">
						<select class="form-control custom-select" id="cabang" name="cabang">
							<option selected="" disabled="">Pilih Cabang</option>
							@foreach ($cabang as $key => $val)
							<option value="{{ $key }}" {{ auth()->user()->cabang_id == $key ? 'selected' : ''}}>{{ $val }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group mb-3 input-sm">
					<input id="tanggal" type="text" class="form-control input-sm tanggal" placeholder="Pilih Bulan" readonly="" value="{{ date('Y/m') }}">
					<div class="input-group-append">
						<button class="btn btn-outline-info" type="button" id="filter">Filter</button>
					</div>
					<button class="btn btn-success mx-2" type="button" id="cetak">Cetak</button>
					{{-- <a href="{{ action('PerkembanganController@cetak') }}" class="btn btn-success mx-2" target="_blank">Cetak</a> --}}
				</div>
			</div>
		</div>
	</div>
	<div id="dataCabang"></div>
</div>
@endsection