<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="row">
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">
						<p>Total Drop</p>
						<h4>Rp. {{ number_format($dataFilter->sum_drop) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
					<div class="inner">
						<p>Total Storting</p>
						<h4>Rp. {{ number_format($dataFilter->sum_storting) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-warning">
					<div class="inner">
						<p>Total PSP</p>
						<h4>Rp. {{ number_format($dataFilter->sum_psp) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-olive">
					<div class="inner">
						<p>Total TKP</p>
						<h4>Rp. {{ number_format($dataFilter->sum_tkp) }}</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-info">
					<div class="inner">
						<p>Total Drop Tunda</p>
						<h4>Rp. {{ number_format($dataFilter->sum_drop_tunda) }}</h4>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-6">
				<!-- small box -->
				<div class="small-box bg-orange">
					<div class="inner">
						<p>Total Angsuran Tunda</p>
						<h4>Rp. {{ number_format($dataFilter->sum_storting_tunda) }}</h4>
					</div>
				</div>
			</div>
			<!-- ./col -->
		</div>
	</div>
</div>

<div class="row">
	<div id="globalChart" class="col-md-12">
		<div class="card card-info card-outline col-md-12">
			<div class="card-header text-center">
				<h3>Data Perkembangan</h3>
				<p>{!! $tanggalFilter !!}</p>
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
							@foreach($globalTable as $k => $val)
							<tr>
								<td>{{ $k }}</td>
								<td>{{ number_format($val['sum_drop']) }}</td>
								<td>{{ number_format($val['sum_storting']) }}</td>
								<td>{{ number_format($val['sum_psp']) }}</td>
								<td>{{ number_format($val['sum_tkp']) }}</td>
								<td>{{ number_format($val['sum_drop_tunda']) }}</td>
								<td>{{ number_format($val['sum_storting_tunda']) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
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
				},
				tooltips: {
					mode: 'index',
					bodySpacing : 10,
					callbacks: {
						label: function(tooltipItem, data) {
                        	// console.log(tooltipItem);.
                        	return number_format(tooltipItem.xLabel);
                        }
                    }
                },

            }
        };
        var drop = new Chart(
        	$('#drop'),
        	config
        	);
    });
</script>
