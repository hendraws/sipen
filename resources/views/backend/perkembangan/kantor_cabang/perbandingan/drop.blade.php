<div class="card card-info card-outline col-md-12">
	<div class="card-header text-center">
		<h3 class="card-title">DROP</h3>

		{{-- <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i>
				</button>
			</div> --}}
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<table class="table table-sm">
						<tr>
							<td class="">KINI</td>
							<td class="text-right">{{ number_format($pencapaian->sum_drop) }}</td>
						</tr>
						<tr>
							<td class="">LALU</td>
							<td class="text-right">{{ number_format($pencapaianBulanLalu->sum_drop) ?? 0  }}</td>
						</tr>
						<tr>
							<td class="">Keterangan</td>
							@php $keteranganDrop = $pencapaian->sum_drop - $pencapaianBulanLalu->sum_drop ; @endphp
							<td class=" {{ $keteranganDrop <= 0 ? 'text-danger' : 'text-success'}} text-right"><b>{{ number_format($keteranganDrop)  }}</b></td>
						</tr>
					</table>
				</div>
				<div class="col-md-9">
					<canvas id="perbandinganDrop"></canvas>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			var perbandinganDrop  = <?= $perbandinganDrop ?>;
			var perbandinganLabels  = <?= $perbandinganLabels ?>;

			const data = {
				labels: perbandinganLabels,
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
					plugins: {
						colorschemes: {
							scheme: 'brewer.Paired12'
						}
					},
					tooltips: {
						mode: 'index',
						bodySpacing : 10,
						callbacks: {
							label: function(tooltipItem, data) {
                        	// console.log(tooltipItem);
                        	return 'Rp.'+number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        };
        var perbandinganDrop = new Chart(
        	$('#perbandinganDrop'),
        	config
        	);
    });
</script>
