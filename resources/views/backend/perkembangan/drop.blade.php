<div class="card card-info card-outline col-md-12 collapsed-card">
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
	{{-- <div class="card-footer">
		<table class="table table-sm">
			<thead>
				<tr>
					<th scope="col">#</th>
					@foreach ($table as $k => $v)
						<th scope="col">{{ $k }}</th>						
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
				@foreach ($table as $k => $v)
					@foreach ($v as $val)
					<th scope="col">{{ $val }}</th>						
					@endforeach
				@endforeach
				</tr>
			</tbody>
		</table>
	</div> --}}
</div>

<script type="text/javascript">

	$(document).ready(function () {
		var dataset  = <?= $data ?>;
		var label  = <?= $labels ?>;
		console.table(dataset);
		const data = {
			labels:label,
			datasets: dataset,
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
		var drop = new Chart(
			$('#drop'),
			config
			);
	});
</script>
