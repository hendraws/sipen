<div class="card card-primary card-outline col-md-12">
	<div class="card-header text-center">
		<h3 class="card-title">DROP TUNDA</h3>
{{-- 		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
			<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				<i class="fas fa-times"></i>
			</button>
		</div> --}}
	</div>
	<div class="card-body">
		@php 
		$dropTundaPencapaianPersent = round(($pencapaian->sum_drop_tunda / $target->sum_drop_tunda) *100,2);
		$dropTundaTargetPersent = 100 - $dropTundaPencapaianPersent;
		if($dropTundaTargetPersent <= 0)
		{
			$dropTundaTargetPersent = 0;
		}
		@endphp
		<div class="row">
			<div class="col-md-6">
				<table class="table table-sm">
					<tr>
						<td class="bg-info">KINI</td>
						<td class="text-right">{{ number_format($pencapaian->sum_drop_tunda) }}</td>
					</tr>
					<tr>
						<td class="bg-info">TARGET</td>
						<td class="text-right">{{ number_format($target->sum_drop_tunda) }}</td>
					</tr>
					<tr>
						<td class="bg-info">Keterangan</td>
						@php $keterangandropTunda = $pencapaian->sum_drop_tunda - $target->sum_drop_tunda ; @endphp
						<td class=" {{ $keterangandropTunda <= 0 ? 'text-danger' : 'text-success'}} text-right"><b>{{ number_format($keterangandropTunda)  }}</b></td>
					</tr>

				</table>

			</div>
			<div class="col-md-6">
				
				<canvas id="dropTunda"></canvas>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function () {
		var dataset  = [10,10];
		var label  = ['pencapaian','target'];
		const data = {
			labels:label,
			datasets: [{
				data: [<?= $dropTundaPencapaianPersent ?>,<?= $dropTundaTargetPersent ?>]
			}],
		};
		const config = {
			type: 'doughnut',
			data,
			options: {
				tooltips: {
					mode: 'dataset',
					bodySpacing : 10,
					callbacks: {
						label: function(tooltipItem, data) {
							return data['labels'][tooltipItem['index']] +' : '+ data['datasets'][0]['data'][tooltipItem['index']] + '%';
						}
					}
				},
				plugins: {
					colorschemes: {
						scheme: 'brewer.PiYG5'
					}
				}
			}
		};
		var dropTunda = new Chart(
			$('#dropTunda'),
			config
			);
	});
</script>
