@extends('layouts.app_master')
@section('title', 'Perkembangan')
@section('content-title', 'Informasi Perkembangan KSP Satria Mulia Arthomoro')
@section('css')
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script type="text/javascript">
	$('body').addClass('sidebar-mini sidebar-collapse');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function number_format(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}
	function getGraphic(target){
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		$.ajax({
			{{-- url: "{{ url()->current() }}?startdate="+startDate+"&enddate="+endDate+"&graphic="+target, --}}
			url: "{{ url()->current() }}?graphic="+target,
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
	
	$(document).ready(function () {
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		// $(document).on('click', '#cetak', function(){
		// 	$('#cetak').printThis({
		// 		canvas: true,
		// 	});
		// });
	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header row">
		<div class="ml-auto">
			{{-- <button type="button" class="btn btn-brand btn-success btn-sm float-right" id="cetak"><i class="cui-filter"></i><span>Cetak</span></button> --}}
			<a href="{{ action('PerkembanganController@cetak') }}" class="btn btn-success">CETAK</a>
			{{-- <button type="button" class="btn btn-brand btn-success btn-sm float-right" id="cetak"><i class="cui-filter"></i><span>Cetak</span></button> --}}
		</div>
	</div>
</div>
<div class="card card-primary card-outline card-outline-tabs">
	<div class="card-header p-0 border-bottom-0">
		<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Grafik</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tabel</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Pencapaian</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Perbandingan</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content " id="custom-tabs-four-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
				<div id="tab-grafik row">
					<div class="col-md-8 m-auto ">
						@includeIf('backend.perkembangan.global.global_chart')
					</div>
				</div>
			</div>
			<div class="tab-pane fade " id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
				<div id="tab-grafik row">
					<div class="col-md-12 m-auto">
						@includeIf('backend.perkembangan.global.table')
					</div>
				</div> 
			</div>
			<div class="tab-pane fade " id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
				@includeIf('backend.perkembangan.global.chart.pencapaian_drop')
				@includeIf('backend.perkembangan.global.chart.pencapaian_storting')
				@includeIf('backend.perkembangan.global.chart.pencapaian_tkp')
				@includeIf('backend.perkembangan.global.chart.pencapaian_drop_tunda')
				@includeIf('backend.perkembangan.global.chart.pencapaian_storting_tunda')
			</div>
			<div class="tab-pane fade " id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
				@includeIf('backend.perkembangan.global.perbandingan.drop')
				@includeIf('backend.perkembangan.global.perbandingan.storting')
				@includeIf('backend.perkembangan.global.perbandingan.tkp')
				@includeIf('backend.perkembangan.global.perbandingan.drop_tunda')
				@includeIf('backend.perkembangan.global.perbandingan.storting_tunda')
			</div>
		</div>
	</div>
	<!-- /.card -->
</div>
@endsection