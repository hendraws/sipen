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
