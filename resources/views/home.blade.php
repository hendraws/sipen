@extends('layouts.app_master')
@section('title', 'Dashboard')
@section('content-title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
<script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script>

<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function number_format(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}
	function getGraphic(target,startDate,endDate){
		$.ajax({
			url: "{{ url()->current() }}?graphic="+target+"&startdate="+startDate+"&enddate="+endDate,
			type: "get",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#"+target).empty().html(data);
			$('[data-toggle="tooltip"]').tooltip();
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}
	
	$(document).ready(function () {
		Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		$('#startdate').datetimepicker({
			format: 'Y-m-d',
			onShow: function (ct) {
				this.setOptions({
					maxDate: $('#enddate').val() ? $('#enddate').val() : false,
				})
			},
			defaultDate: '{{ now()->subMonths('3') }}',
			setDate: '2019-12-28',
			timepicker: false,
			lang:'id'
		});
		$(document).on('click', '.submit-search-self', function(){
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			let startDate = $('#startdate').val();
			let endDate = $('#enddate').val();
			getGraphic('globalChart', startDate, endDate);
		});
		$('#enddate').datetimepicker({
			format: 'Y-m-d',
			onShow: function (ct) {
				this.setOptions({
					minDate: $('#startdate').val() ? $('#startdate').val() : false,
					maxDate: 0,
				})
			},
			defaultDate: '{{ now()->subDay() }}',
			timepicker: false,
			lang:'id'
		});
		let startDate = $('#startdate').val();
		let endDate = $('#enddate').val();
		getGraphic('globalChart', startDate, endDate);

		$(document).on('click', '#cetak', function(){
			$('#globalChart').printThis({
				canvas: true,
			});
		});
	});
	
</script>
@endsection
@section('content')
<div class="container">
	<div class="card card-body">
		<div class="input-group mb-0">
			<div class="input-group-addon">
				<div class="input-group-text">Dari</div>
			</div>
			<input type="text" id="startdate" name="startdate" value="{{$startdate->format('Y-m-d')}}" class="form-control form-control-sd mb-0" autocomplete="off" style="width: 100px;" />
			<div class="input-group-addon">
				<div class="input-group-text">Sampai</div>
			</div>
			<input type="text" id="enddate" name="enddate" value="{{$enddate->format('Y-m-d')}}" class="form-control form-control-sd mb-0" autocomplete="off" style="width: 100px;" />
			<button type="button" class="btn btn-brand btn-primary submit-search-self ml-2"><i class="cui-filter"></i><span>Filter</span></button>
			<a href="{!! url()->current() !!}" class="btn btn-brand btn-secondary ml-2"><i class="cui-action-undo"></i><span>Reset</span></a>&nbsp;
			<button type="button" class="btn btn-brand btn-success ml-2" id="cetak"><i class="cui-filter"></i><span>Cetak</span></button>
		</div>
	</div>
	<div id="globalChart"></div>
</div>
@endsection
