@extends('layouts.app_master')
@section('title', 'Target & Perkembangan Berjalan ')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function () {
		$("#bulan").datepicker( {
			format: "yyyy-mm-dd",
			// startView: "months", 
			// minViewMode: "months"
		});
		$("#tanggal").datepicker( {
			format: "yyyy-mm-dd",
		}).on('changeDate', function(ev){
			getPasaran($(this).val());
		});

		// var resort = $('#resort_id').val();
		// var tanggal = $('#bulan').val();
		{{-- var url = "{{ url()->current() }}?tanggal="+tanggal+"&data=dataTarget"; --}}
		// getDataTable(url, '#dataTarget')
		// getDataTable(url, '#dataTarget')

	});

	function getPasaran(tanggal){
		var d = new Date(tanggal);
		var cekDay = d.getDay();
		var key = val = '';

		if(cekDay == 1 || cekDay == 4){
			key = 1;
			val = "Senin - Kamis"; 
		}

		if(cekDay == 2 || cekDay == 5){
			key = 2;
			val = "Selasa - Jum'at"; 
		}

		if(cekDay == 3 || cekDay == 6){
			key = 3;
			val = "Rabu - Sabtu"; 
		}
		var option = '<option value='+key+' selected>'+ val +'</option>'
		$('#pasaran').html(option);
	}

	
	$(document).on('click', '#filter', function(){
		var cabang = $('#cabang').val();
		var namaCabang = $('#cabang option:selected').text();
		var tanggal = $('#bulan').val();
		var url = "{{ url()->current() }}?data=target&tanggal="+tanggal+"&cabang="+cabang;
		var urlDrop =  "{{ url()->current() }}?data=drop&tanggal="+tanggal+"&cabang="+cabang;
		var urlStorting =  "{{ url()->current() }}?data=storting&tanggal="+tanggal+"&cabang="+cabang;
		var urlKalkulasi =  "{{ url()->current() }}?data=kalkulasi&tanggal="+tanggal+"&cabang="+cabang;
		getDataTable(url, '#dataTarget');
		getDataTable(urlDrop, '#dataDrop');
		getDataTable(urlStorting, '#dataStorting');
		getDataTable(urlKalkulasi, '#dataKalkulasi');
		$('H1').html('Target & Perkembangan Berjalan Cabang '+ namaCabang);
		// if(resort == null){
		// 	return Swal.fire({title: 'Pilih Resort Terlebih dahulu', icon: 'warning', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		// }
		// getDataTable(url, '#data-table')
	});

	$(document).on('click', '#cetak', function(){
		var tanggal = $('#bulan').val();
		var cabang = $('#cabang').val();

		console.log("{{ action('TargetController@cetak') }}?data=cetak&tanggal="+tanggal+"&cabang="+cabang);
	});

	$(document).on('click', '#print', function(){
		var tanggal = $('#bulan').val();
		var cabang = $('#cabang').val();		
		var url = "{{ action('TargetController@report') }}?tanggal="+tanggal+"&cabang="+cabang;
		console.log(url);
		$(location).attr('href', url);
	});

	var urlDrop =  "{{ url()->current() }}?data=drop";
	var urlStorting =  "{{ url()->current() }}?data=storting";
	var urlKalkulasi =  "{{ url()->current() }}?data=kalkulasi";
	var url = "{{ url()->current() }}?data=target";
	getDataTable(url, '#dataTarget');
	getDataTable(urlDrop, '#dataDrop');
	getDataTable(urlStorting, '#dataStorting');
	getDataTable(urlKalkulasi, '#dataKalkulasi');

	
</script>
@endsection
@section('content-title', 'Target & Perkembangan Berjalan Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
@section('content')
<div class="card card-outline card-primary collapsed-card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-4">
				{{-- <h3 class="card-title">Input Data</h3> --}}
			</div>
			<div class="col-md-3">
				<select class="form-control" name="cabang" id="cabang">
					<option disabled="" selected>Pilih Cabang</option>
					@foreach ($cabang as $k => $v)
					<option value="{{ $k }}" data-nama="{{ $v }}" {{ auth()->user()->cabang_id == $k ? 'selected' : '' }}>{{ $v }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-5 ml-auto">
				
				<div class="input-group mb-3 input-sm">
					<input type="text" class="form-control input-sm " placeholder="Pilih Bulan" readonly="" id="bulan" value="{{ date('Y-m-d') }}">
					<button class="btn btn-outline-info ml-2" type="button" id="filter">Filter</button>
					<button type="button"  id="print" class="btn btn-success  mx-2 float-right" >Cetak Report</button>
					<div class="card-tools ml-2">
						<button type="button" class="btn btn-primary" data-card-widget="collapse">Tambah
						</button>
					</div>
				</div>
			</div>
		</div>


		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body" style="display: none;">
		@includeIf('backend.target.create')
	</div>
	<!-- /.card-body -->
</div>

<div id="data-table"></div>
<div class="card card-lightblue card-tabs">
	<div class="card-header p-0 pt-1">
		<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
			{{-- <li class="pt-2 px-3"><h3 class="card-title"></h3></li> --}}
			<li class="nav-item">
				<a class="nav-link active" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="true">TARGET</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">DROP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">STORTING</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-kalkulasi-tab" data-toggle="pill" href="#custom-tabs-kalkulasi" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">KALKULASI</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content" id="custom-tabs-two-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
				<div id="dataTarget">
					{{-- @includeIf('backend.target.table') --}}
				</div>
			</div>
			<div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
				<div id="dataDrop"></div>
			</div>
			<div class="tab-pane fade" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
				<div id="dataStorting"></div>

			</div>	
			<div class="tab-pane fade" id="custom-tabs-kalkulasi" role="tabpanel" aria-labelledby="custom-tabs-kalkulasi-tab">
				<div id="dataKalkulasi"></div>
			</div>

		</div>
	</div>
	<!-- /.card -->
</div>
@endsection
