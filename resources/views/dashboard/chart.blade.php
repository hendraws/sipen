<div class="card card-info card-outline col-md-12">
	<div class="card-header text-center">
		<h3>Data Perkembangan</h3>
		<p>Tanggal : {{ date('d F Y') }}</p>
	</div>
	<div class="card-body">
		<div>
			<canvas id="drop"></canvas>
		</div>
	</div>
	<div class="card-footer">
		<div class="table-responsive">
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col">UNIT</th>
						<th scope="col">DROP</th>
						<th scope="col">STORTING</th>
						<th scope="col">PSP</th>
						<th scope="col">TKP</th>
						<th scope="col">DROP TUNDA</th>
						<th scope="col">STORTING TUNDA</th>
					</tr>
				</thead>
				<tbody>
					@foreach($chart as $k => $val)
					<tr>
						<td>{{ $val->Cabang->cabang }}</td>
						<td>{{ number_format($val->sum_drop) }}</td>
						<td>{{ number_format($val->sum_storting) }}</td>
						<td>{{ number_format($val->sum_psp) }}</td>
						<td>{{ number_format($val->sum_tkp) }}</td>
						<td>{{ number_format($val->sum_drop_tunda) }}</td>
						<td>{{ number_format($val->sum_storting_tunda) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function () {
		var dataset  = <?= $dataset ?>;
		var label  = <?= $labels ?>;

		const data = {
			labels:label,
			datasets: dataset,
		};
		const config = {
			type: 'horizontalBar',
			data,
			options: {
						// indexAxis: 'y',
						responsive: true,
						elements: {
							bar: {
								borderWidth: 2,
							}
						},
						plugins: {
							legend: {
								position: 'right',
							},
							title: {
								display: true,
								text: 'Chart.js Horizontal Bar Chart'
							}
						},
						scales: {
							xAxes: [{
								stacked: true
							}],
							yAxes: [{
								stacked: true
							}]
						}

					}
				};
				var drop = new Chart(
					$('#drop'),
					config
					);
			});
		</script>
