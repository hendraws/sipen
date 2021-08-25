<div class="card card-info card-outline col-md-12 mt-3">
	<div class="card-header text-center">
		<h3 class="card-title">DROP</h3>
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
		$dropPencapaianPersent = round(($pencapaian->sum_drop / $target->sum_drop) *100,2);
		$dropTargetPersent = 100 - $dropPencapaianPersent;
		if($dropTargetPersent <= 0)
		{
			$dropTargetPersent = 0;
		}
		@endphp
		<div class="row">
			<div class="col-md-6">
				<table class="table table-sm">
					<tr>
						<td class="">KINI</td>
						<td class="text-right">{{ number_format($pencapaian->sum_drop) }}</td>
					</tr>
					<tr>
						<td class="">TARGET</td>
						<td class="text-right">{{ number_format($target->sum_drop) }}</td>
					</tr>
					<tr>
						<td class="">Keterangan</td>
						@php $keteranganDrop = $pencapaian->sum_drop - $target->sum_drop ; @endphp
						<td class=" {{ $keteranganDrop <= 0 ? 'text-danger' : 'text-success'}} text-right"><b>{{ number_format($keteranganDrop)  }}</b></td>
					</tr>

				</table>

			</div>
			<div class="col-md-6">
				
				<canvas id="drop"></canvas>
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
				data: [<?= $dropPencapaianPersent ?>,<?= $dropTargetPersent ?>]
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
						scheme: 'brewer.Paired12'
					}
				}
			}
		};
		var drop = new Chart(
			$('#drop'),
			config
			);
	});
</script>
