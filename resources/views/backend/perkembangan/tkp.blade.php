<div class="card card-info card-outline col-md-12 collapsed-card">
	<div class="card-header text-center">
		 <h3 class="card-title">TKP</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
	</div>
	<div class="card-body">
		<div>
			<canvas id="tkp"></canvas>
		</div>
	</div>
	{{-- <div class="card-footer">
		<table class="table table-sm">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">First</th>
					<th scope="col">Last</th>
					<th scope="col">Handle</th>
				</tr>
			</thead>
		</table>
	</div> --}}
</div>

<script type="text/javascript">

	$(document).ready(function () {
		var dataset  = <?= $data ?>;
		var label  = <?= $labels ?>;

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
				}
			}
		};
		var tkp = new Chart(
			$('#tkp'),
			config
			);
	});
</script>
