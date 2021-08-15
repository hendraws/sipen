@extends('layouts.app_master')
@section('title', 'Perkembangan')
@section('content-title', 'Perkembangan')
@section('css')
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {

		const labels = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		];
		const data = {
			labels: labels,
			datasets: [{
				label: 'My First dataset',
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				data: [0, 10, 5, 2, 20, 30, 45],
			}]
		};

		const config = {
			type: 'line',
			data,
			options: {}
		};

		 var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header">
		{{-- <a class="btn btn-sm btn-primary modal-button float-right" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KantorCabangController@create') }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Tambah Data</a> --}}
		<a href="{{ action('ProgramKerjaController@create') }}" class="btn btn-primary btn-sm float-right">Filter</a>
	</div>
	<div class="card-body">
		<div>
			<canvas id="myChart"></canvas>
		</div>
	</div>
</div>

@endsection
