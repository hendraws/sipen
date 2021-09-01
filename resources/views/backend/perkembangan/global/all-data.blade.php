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
	<script type="text/javascript">
		$('#bulan').html("{{ $getBulan }}");
	</script>