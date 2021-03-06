<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/print-this.js')}}"></script>
<script type="text/javascript">
var tanggal = "{{ $tgl }}";
var cabang = "{{ $cabang }}";
var urlKemacetan = "{{ url()->current() }}?tanggal="+tanggal+"&cabang="+cabang+"&data=kemacetan";
var urlCalonMacet = "{{ url()->current() }}?tanggal="+tanggal+"&cabang="+cabang+"&data=calonMacet";
var urlKalkulasi = "{{ url()->current() }}?tanggal="+tanggal+"&cabang="+cabang+"&data=dataKalkulasi";
getDataTable(urlKemacetan, '#dataKemacetan'); //get Data Kemacetan
getDataTable(urlCalonMacet, '#dataCalonMacet'); //get Data Kemacetan
getDataTable(urlKalkulasi, '#dataKalkulasi'); //get Data Kemacetan
$(document).ready(function () {
	$('#settingHk').hide();
	setTimeout(function(){ window.print() }, 2000);
})
</script>
<style type="text/css">

	@media print {
		body{
			margin: 0;
			color: #000;
			background-color: #fff;
		}

		.table-breaked {
			page-break-before: auto;
		}
		.swal2-container{
			display: none;
		}	
		#filter{
			display: none;
		}
		footer{
			display: none;
		}
	}
</style>

<div class="card card-primary card-outline card-outline-tabs">
	<div class="card-header p-0 border-bottom-0">
		<div class="col-md-12 my-4" id="getBulan">
			<h5>Bulan {{ $getBulan }}</h5>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-3">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">
						<h6>DROP</h6>
						<div class="row">
							<div class="col-6"></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_drop) }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-md-3">
				<!-- small box -->
				<div class="small-box bg-success">
					<div class="inner">
						<h6>STORTING</h6>
						<div class="row">
							<div class="col-6"><h6>IP {{ $dashboard->sum_drop != 0 ? round($dashboard->sum_storting / $dashboard->sum_drop * 100) : 0 }} %</h6></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_storting) }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-md-3">
				<!-- small box -->
				<div class="small-box bg-warning">
					<div class="inner">
						<h6>PSP</h6>
						<div class="row">
							<div class="col-6"></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_psp) }}</h6>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- ./col -->
			<div class="col-md-3">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h6>TKP</h6>
						<div class="row">
							<div class="col-6"><h6>IP {{ $dashboard->sum_drop != 0 ? round($dashboard->sum_tkp / $dashboard->sum_drop * 100) : 0 }} %</h6></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_tkp) }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 ">
				<!-- small box -->
				<div class="small-box bg-lime">
					<div class="inner">
						<h6>DROP TUNDA</h6>
						<div class="row">
							<div class="col-6"></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_drop_tunda) }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<!-- small box -->
				<div class="small-box bg-lightblue">
					<div class="inner">
						<h6>STORTING TUNDA</h6>
						<div class="row">
							<div class="col-6"><h6>IP {{$dashboard->sum_drop_tunda != 0 ? round($dashboard->sum_storting_tunda / $dashboard->sum_drop_tunda * 100) : 0}} %</h6></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ number_format($dashboard->sum_storting_tunda) }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 	">
				<!-- small box -->
				<div class="small-box bg-orange">
					<div class="inner">
						<h6>KAS TERBARU</h6>
						<div class="row">
							<div class="col-6"></div>
							<div class="col-6">
								<h6 class="text-right">Rp. {{ !empty($kasTerbaru) ? number_format($kasTerbaru->sisa_kas) : 0 }}</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./col -->
		</div>
	</div>
	<div class="card-body">
		<h1  class="my-3">Pencapaian </h1>
		<div class="row">
			<div class="col-md-12">
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.drop')
			</div>
		</div>
		<div class="col-md-12">
			@includeIf('backend.perkembangan.kantor_cabang.pencapaian.storting')
			
		</div>
		<div class="col-md-12">
			@includeIf('backend.perkembangan.kantor_cabang.pencapaian.tkp')
			
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<div class="col-md-12">
			
			@includeIf('backend.perkembangan.kantor_cabang.pencapaian.drop_tunda')
		</div>
		<div class="col-md-12">
			@includeIf('backend.perkembangan.kantor_cabang.pencapaian.storting_tunda')
			
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<h1 class="my-3">Perbandingan</h1>
		<div class="col-md-11">
			@includeIf('backend.perkembangan.kantor_cabang.perbandingan.drop')
			
		</div>
		<div class="col-md-11">
			@includeIf('backend.perkembangan.kantor_cabang.perbandingan.storting')
			
		</div>
		<div class="col-md-11">
			@includeIf('backend.perkembangan.kantor_cabang.perbandingan.tkp')
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<div class="col-md-11">
			@includeIf('backend.perkembangan.kantor_cabang.perbandingan.drop_tunda')
			
		</div>
		<div class="col-md-11">
			@includeIf('backend.perkembangan.kantor_cabang.perbandingan.storting_tunda')
			
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<h1 class="my-3">Kemacetan</h1>
		<div class="row">
			<div class="col-md-12">
				<div id="dataKemacetan"></div>
			</div>
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<h1 class="my-3">Calon Macet</h1>
		<div class="row">
			<div class="col-md-12">
				<div id="dataCalonMacet"></div>
			</div>
		</div>
		<div class="display" id="break_page" style='page-break-after:always'></div>
		<h1 class="my-3">Kalkulasi</h1>
		<div class="row">
			<div class="col-md-12">
				<div id="dataKalkulasi"></div>
			</div>
		</div>
	</div>
	<!-- /.card -->
</div>
