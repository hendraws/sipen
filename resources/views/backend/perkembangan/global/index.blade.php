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
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script type="text/javascript">
	$('body').addClass('sidebar-mini sidebar-collapse');

	$(".tanggal").datepicker( {
		format: "yyyy/mm",
		startView: "months", 
		minViewMode: "months"
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function number_format(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}
	function getGraphic(date,statusPrint,target){
		$.ajax({
			url: "{{ url()->current() }}?tanggal="+date+"&print="+statusPrint,
			type: "post",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#"+target).empty().html(data);
			$('[data-toggle="tooltip"]').tooltip();
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}

	$(document).on('click', '#filter', function(){
		Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		getGraphic($('.tanggal').val(), false,'allData');
	});

	$(document).on('click', '#cetak', function(){
		if($('.tanggal').val() === ''){
			return Swal.fire({title: ' Silahkan Pilih Bulan terlebih dahulu', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		}
		getGraphic($('.tanggal').val(), true,'allprint');
	});

	getGraphic($('.tanggal').val(), false,'allData');
	
</script>
@endsection
@section('content')
<div id="allprint">
	<div class="card card-primary card-outline">
		<div class="card-header">
			<div class="row">
				<div class="col-md-8">
					<h4><span id="bulan"></span></h4>
				</div>
				<div class="col-md-4 ml-auto">
					<div class="input-group mb-3 input-sm">
						<input type="text" class="form-control input-sm tanggal" placeholder="Pilih Bulan" readonly="" value="{{ date('Y/m') }}">
						<div class="input-group-append">
							<button class="btn btn-outline-info" type="button" id="filter">Filter</button>
						</div>
						<button class="btn btn-success mx-2" type="button" id="cetak">Cetak</button>
						{{-- <a href="{{ action('PerkembanganController@cetak') }}" class="btn btn-success mx-2" target="_blank">Cetak</a> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card card-primary card-outline card-outline-tabs">
		<div id="allData"></div>
	</div>
</div>
@endsection