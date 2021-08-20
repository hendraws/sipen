<div class="card card-info card-outline col-md-12">
	<div class="card-header text-center">
		<h3 class="card-title">DROP</h3>

		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-plus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i></button>
				</div>
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
