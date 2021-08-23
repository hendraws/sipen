@extends('layouts.app_master')
@section('title', 'Tambah Program Kerja')
@section('content-title', 'Program Kerja Cabang '. ucfirst(auth()->user()->getCabang->cabang))
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script>
<script type="text/javascript">
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

		let table = $('#data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ url()->full() }}",
			pageLength: 25,
			responsive: true,
			autoWidth : false,
			// scrollX: "100%",
			scrollCollapse:false,
			columnDefs: [
			// {targets: [7], className: "text-center"},
			// {targets: [0,1], className: "text-left"},
			// {targets: [2,3,4,5,6], className: "text-right"},
			// {targets: 0, width: "10px"},
			],
			columns: [
			{data: 'hari_kerja',name:'hari_kerja',orderable: false,searchable: false},
			{data: 'drop', name: 'drop'},
			{data: 'storting', name: 'storting'},
			{data: 'tkp', name: 'tkp'},
			{data: 'drop_tunda', name: 'drop_tunda'},
			{data: 'storting_tunda', name: 'storting_tunda'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
</script>
@endsection

@section('content')
<div class="card card-outline card-primary collapsed-card">
	<div class="card-header">
		<h3 class="card-title">Input Data</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">Tambah
			</button>
		</div>
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body" style="display: none;">
		@includeIf('backend.perkembangan.data.create')
	</div>
	<!-- /.card-body -->
</div>

<div class="card card-success card-outline">
	<div class="card-body">
		<div class="table-responsive">
			<table id="data-table" class="table table-sm">
				<thead>
					<tr>
						<th scope="col">HARI KERJA</th>
						<th scope="col">DROP</th>
						<th scope="col">STORTING</th>
						<th scope="col">PSP</th>
						<th scope="col">DROP TUNDA</th>
						<th scope="col">STORTING TUNDA</th>
						<th scope="col">AKSI</th>
					</tr>
				</thead>
			</table>
		</div>
	</div><!-- /.card-body -->
	<hr>
	<div class="card-footer">
		<div class="row">
			<div class="col-md-12">
				Total berjalan
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col">HARI KERJA</th>
						<th scope="col">DROP</th>
						<th scope="col">STORTING</th>
						<th scope="col">PSP</th>
						<th scope="col">DROP TUNDA</th>
						<th scope="col">STORTING TUNDA</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td scope="col">{{ $globalData->hari_ke }}</td>
						<td scope="col">{{ number_format($globalData->sum_drop) }}</td>
						<td scope="col">{{ number_format($globalData->sum_storting) }}</td>
						<td scope="col">{{ number_format($globalData->sum_psp) }}</td>
						<td scope="col">{{ number_format($globalData->sum_drop_tunda) }}</td>
						<td scope="col">{{ number_format($globalData->sum_storting_tunda) }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
