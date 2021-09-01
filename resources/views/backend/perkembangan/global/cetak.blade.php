<style type="text/css">
	@page{
		padding: 20px;
	}
	@media print {
		.table-breaked {
			page-break-before: auto;
		}

		footer{
			display: none;
		}
	}
	#bg-total{
		
		color: black !important;
	}
	.swal2-container.swal2-top-end.swal2-backdrop-show{
		display: none;
	}
</style>
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
	
	$(document).ready(function () {
		setTimeout(function(){ window.print() }, 2000);
	});
</script>

<div id="cetak">
	<div class="card card-primary card-outline card-outline-tabs">

		<div class="card-body table-breaked">
			<h5>Bulan {{ $getBulan }}</h5>
			<hr>
			<h1 class="m-2">Global</h1>
			@includeIf('backend.perkembangan.global.global_chart')

			@includeIf('backend.perkembangan.global.table')
			<div class="display" id="break_page" style='page-break-after:always'></div>
			<h1 class="m-2">Pencapaian</h1>
			@includeIf('backend.perkembangan.global.chart.pencapaian_drop')
			@includeIf('backend.perkembangan.global.chart.pencapaian_storting')
			@includeIf('backend.perkembangan.global.chart.pencapaian_tkp')
			@includeIf('backend.perkembangan.global.chart.pencapaian_drop_tunda')
			<div class="display" id="break_page" style='page-break-after:always'></div>
			@includeIf('backend.perkembangan.global.chart.pencapaian_storting_tunda')
			<h1 class="m-2">Perbandingan</h1>
			@includeIf('backend.perkembangan.global.perbandingan.drop')
			@includeIf('backend.perkembangan.global.perbandingan.storting')
			<div class="display" id="break_page" style='page-break-after:always'></div>
			@includeIf('backend.perkembangan.global.perbandingan.tkp')
			{{-- <div class="display" id="break_page" style='page-break-after:always'></div> --}}
			@includeIf('backend.perkembangan.global.perbandingan.drop_tunda')
			@includeIf('backend.perkembangan.global.perbandingan.storting_tunda')
			

		</div>
		<!-- /.card -->
	</div>
</div>