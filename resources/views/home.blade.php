@extends('layouts.app_master')
@section('title', 'Dashboard')
@section('content-title', 'Dashboard')
@section('content')
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
<script type="text/javascript">

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
			type: "get",
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
		Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		getGraphic('globalChart');
	});
</script>
@endsection
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="row">
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<p>Total Drop</p>
							<h4>Rp. {{ number_format($data->sum_drop) }}</h4>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<p>Total Storting</p>
							<h4>Rp. {{ number_format($data->sum_storting) }}</h4>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<p>Total PSP</p>
							<h4>Rp. {{ number_format($data->sum_psp) }}</h4>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-olive">
						<div class="inner">
							<p>Total TKP</p>
							<h4>Rp. {{ number_format($data->sum_tkp) }}</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<p>Total Drop Tunda</p>
							<h4>Rp. {{ number_format($data->sum_drop_tunda) }}</h4>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-6">
					<!-- small box -->
					<div class="small-box bg-orange">
						<div class="inner">
							<p>Total Angsuran Tunda</p>
							<h4>Rp. {{ number_format($data->sum_storting_tunda) }}</h4>
						</div>
					</div>
				</div>
				<!-- ./col -->
			</div>
		</div>
	</div>
	<div class="row">
		<div id="globalChart" class="col-md-12"></div>
	</div>
</div>
@endsection
