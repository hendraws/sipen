@extends('layouts.app_master')
@section('title', 'Tambah Program Kerja')
@section('content-title', 'Tambah Program Kerja')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet"> --}}

@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>
{{-- <script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script> --}}
<script type="text/javascript">
	$(document).ready(function () {
		let storting = psp = drop = 0;
		$('#cabang').select2({
			theme: 'bootstrap4'
		})
		$(".tanggal").datepicker( {
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
			console.log(storting,drop, psp);
			var jumlah = storting - ( drop / 100 * 91 ) -  psp; 
			$('#tkp').val(jumlah);
		}
	});
</script>
@endsection

@section('content')
<div class="card card-primary card-outline">
	<div class="card-body">
		<form action="{{ action('ProgramKerjaController@store') }}" method="POST" id="kantorCabangForm">
			@csrf
			<div class="form-group">
				<label for="inputName">Kantor Cabang</label>
				<select class="form-control custom-select" id="cabang" name="cabang">
					<option selected="" disabled="">Pilih Cabang</option>
					@foreach ($cabang as $key => $val)
					<option value="{{ $key }}">{{ $val }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="tanggal">Bulan</label>
				<input type="text" id="tanggal" class="form-control tanggal bg-white" name="tanggal"  autocomplete="off" readonly="">
			</div>
			<div class="form-group">
				<label for="drop">Drop</label>
				<input type="number" id="drop" class="form-control" name="drop">
			</div>
			<div class="form-group">
				<label for="storting">Storting</label>
				<input type="number" id="storting" class="form-control hitung" name="storting">
			</div>
			<div class="form-group">
				<label for="tkp">TKP</label>
				<input type="number" id="tkp" class="form-control bg-white" name="tkp" readonly>
			</div>
			<div class="form-group">
				<label for="drop_tunda">Drop Tunda</label>
				<input type="number" id="drop_tunda" class="form-control" name="drop_tunda">
			</div>
			<div class="form-group">
				<label for="storting_tunda">Storting Tunda</label>
				<input type="number" id="storting_tunda" class="form-control" name="storting_tunda">
			</div>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>

			</div>
		</form>
	</div>
</div>

@endsection
