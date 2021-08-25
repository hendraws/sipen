<script type="text/javascript">
	setTimeout(function(){ window.print() }, 2000);
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
							<div class="col-6"><h6>IP {{ round($dashboard->sum_storting / $dashboard->sum_drop * 100) }} %</h6></div>
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
							<div class="col-6"><h6>IP {{ round($dashboard->sum_tkp / $dashboard->sum_drop * 100) }} %</h6></div>
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
							<div class="col-6"><h6>IP {{ round($dashboard->sum_storting_tunda / $dashboard->sum_drop_tunda * 100) }} %</h6></div>
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
								<h6 class="text-right">Rp. {{ number_format($kasTerbaru->sisa_kas) }}</h6>
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
		
	</div>
	<!-- /.card -->
</div>
