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

	});
</script>
@endsection
@section('content')
<div class="card card-info card-outline col-md-12 collapsed-card">
	<div class="card-header text-center">
		<h3 class="card-title">DROP</h3>

		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-plus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div>
					<canvas id="drop"></canvas>
				</div>
			</div>
		</div>

		<script type="text/javascript">

			$(document).ready(function () {
				var perbandinganDrop  = <?= $perbandinganDrop ?>;
				var perbandinganLabels  = <?= $perbandinganLabels ?>;

				const data = {
					labels:perbandinganLabels,
					datasets: perbandinganDrop,
				};
				const config = {
					type: 'line',
					data,
					options: {
						elements: {
							line: {
								tension: 0,
								fill: false
							}
						},
				// tooltips: {
				// 	mode: 'index',
				// 	bodySpacing : 10,
				// 	callbacks: {
				// 		label: function(tooltipItem, data) {
    //                     	// console.log(tooltipItem);
				// 			return 'Rp.'+number_format(tooltipItem.yLabel);
				// 		}
				// 	}
				// },
			}
		};
		var drop = new Chart(
			$('#drop'),
			config
			);
	});
</script>

@endsection