@extends('layouts.app_master')
@section('title', 'Perkembangan')
@section('content-title', 'Perkembangan')
@section('css')
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function getGraphic(target){
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
		getGraphic('dropChart');
		getGraphic('stortingChart');
		getGraphic('pspChart');
		getGraphic('dropTundaChart');
		getGraphic('stortingTundaChart');
		getGraphic('tkpChart');
		getGraphic('sisaKasChart');
	});
</script>
@endsection
@section('content')
{{-- <div class="card card-primary card-outline">
	<div class="card-header">
		<div class="form-group row ">
			<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
			<div class="col-sm-4">
				<input type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="">
			</div>
		</div>
		<a href="{{ action('ProgramKerjaController@create') }}" class="btn btn-primary btn-sm float-right">Filter</a>
	</div>
</div> --}}
<div class="row">
	<div id="dropChart" class="col-md-12"></div>
	<div id="stortingChart" class="col-md-12"></div>
	<div id="pspChart" class="col-md-12"></div>
	<div id="dropTundaChart" class="col-md-12"></div>
	<div id="stortingTundaChart" class="col-md-12"></div>
	<div id="tkpChart" class="col-md-12"></div>
	<div id="sisaKasChart" class="col-md-12"></div>
</div>

@endsection
