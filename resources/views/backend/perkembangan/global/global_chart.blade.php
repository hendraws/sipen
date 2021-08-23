<canvas id="globalPerkembangan"></canvas>	

<script type="text/javascript">

	$(document).ready(function () {
		var dataset  = <?= $dataset ?>;
		var label  = <?= $labels ?>;
		const data = {
			labels:label,
			datasets: dataset,
		};
		const config = {
			type: 'bar',
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
                        	// console.log(tooltipItem);
                        	return 'Rp.'+number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        };
        var drop = new Chart(
        	$('#globalPerkembangan'),
        	config
        	);
    });
</script>
