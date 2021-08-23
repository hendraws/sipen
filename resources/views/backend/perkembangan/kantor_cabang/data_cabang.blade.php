<div class="card card-primary card-outline card-outline-tabs">
	<div class="card-header p-0 border-bottom-0">
		<div class="row">
			<div class="col-md-3">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">
						<h6>DROP</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_drop) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
					<div class="inner">
						<h6>STORTING</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_storting) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-warning">
					<div class="inner">
						<h6>PSP</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_psp) }}</h4>
					</div>

				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h6>TKP</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_tkp) }}</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h6>DROP TUNDA</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_drop_tunda) }}</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h6>STORTING TUNDA</h6>
						<h4 class="text-right">Rp. {{ number_format($dashboard->sum_storting_tunda) }}</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
					<div class="inner">
						<h6>KAS TERBARU</h6>
						<h4 class="text-right">Rp. {{ number_format($kasTerbaru->sisa_kas) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
		</div>
		<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Pencapaian</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Perbandingan</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content" id="custom-tabs-four-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.drop')
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.storting')
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.tkp')
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.drop_tunda')
				@includeIf('backend.perkembangan.kantor_cabang.pencapaian.storting_tunda')
			</div>
			<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
				@includeIf('backend.perkembangan.kantor_cabang.perbandingan.drop')
				@includeIf('backend.perkembangan.kantor_cabang.perbandingan.storting')
				@includeIf('backend.perkembangan.kantor_cabang.perbandingan.tkp')
				@includeIf('backend.perkembangan.kantor_cabang.perbandingan.drop_tunda')
				@includeIf('backend.perkembangan.kantor_cabang.perbandingan.storting_tunda')
			</div>
		</div>
	</div>
	<!-- /.card -->
</div>