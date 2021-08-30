@extends('layouts.app_master')
@section('title', 'Data Harian ')
@section('content-title', 'Data Harian Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
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
	function getGraphic(tanggal){
		$.ajax({
			url: "{{ url()->current() }}?tanggal="+tanggal,
			type: "get",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#data-table").empty().html(data);
			$('[data-toggle="tooltip"]').tooltip();
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}

	$(document).ready(function () {
		let storting = psp = drop = 0;
		$('#cabang').select2({
			theme: 'bootstrap4'
		})
		$('.tanggal').datetimepicker({
			format: 'Y-m-d',
			onShow: function (ct) {
				this.setOptions({
					maxDate: "{{ $today }}",
				})
			},
			defaultDate: '{{ \Illuminate\Support\Carbon::now()->subDay() }}',
			setDate: '2019-12-28',
			timepicker: false,
			lang:'id'
		});
		$("#bulan").datepicker( {
			format: "yyyy/mm",
			startView: "months", 
			minViewMode: "months"
		});
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).on('keyup', '#storting', function(){
			storting = $(this).val();
			hitung(storting, drop, psp);
		});

		$(document).on('keyup', '#drop', function(){
			drop = $(this).val();
			hitung(storting, drop, psp);
		});

		$(document).on('keyup', '#psp', function(){
			psp = $(this).val();
			hitung(storting, drop, psp);
		});
		function hitung(storting, drop, psp)
		{
			var jumlah = storting - ( drop / 100 * 91 ) -  psp; 
			$('#tkp').val(jumlah);
		}


		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).on('click', '#filter', function(){
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			getGraphic($('#bulan').val());
		});
		getGraphic("{{ date('Y/m') }}");
	});
</script>
@endsection

@section('content')
<div class="card card-outline card-primary collapsed-card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-4">
				<h3 class="card-title">Input Data</h3>
			</div>
			<div class="col-md-5 ml-auto">
				
				<div class="input-group mb-3 input-sm">
					<input type="text" class="form-control input-sm " placeholder="Pilih Bulan" readonly="" id="bulan">
					<div class="input-group-append">
						<button class="btn btn-outline-info" type="button" id="filter">Filter</button>
					</div>
					<a href="{{ action('PerkembanganController@printHarian') }}" class="btn btn-success  mx-2 float-right" target="_blank">Cetak</a>
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
		@includeIf('backend.perkembangan.data.create')
	</div>
	<!-- /.card-body -->
</div>

<div id="data-table"></div>

@endsection
	