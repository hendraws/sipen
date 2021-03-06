@extends('layouts.app_master')
@section('title', 'Edit Program Kerja')
@section('content-title', 'Edit Program Kerja')
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
		let storting =  $('#storting').val();
		let psp = 0;
		let drop = $('#drop').val();
		// $('#cabang').select2({
		// 	theme: 'bootstrap4'
		// })

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
			$('#tkp').val(Math.round(jumlah));
		}
	});
</script>
@endsection

@section('content')
<div class="card card-primary card-outline">
	<div class="card-body">
		<form action="{{ action('ProgramKerjaController@update', $data->id) }}" method="POST" id="kantorCabangForm">
			@csrf
			@method('PATCH')
			<div class="form-group">
				<label for="cabang">Kantor Cabang</label>
				<input type="text" id="tanggal" class="form-control tanggal" readonly autocomplete="off" value="{{optional($data->Cabang)->cabang }}">
			</div>
			<div class="form-group">
				<label for="tanggal">Bulan</label>
				<input type="text" id="tanggal" class="form-control tanggal" name="tanggal" readonly autocomplete="off" value="{{ date_format(date_create_from_format('Y-m-d', $data->tanggal), 'F') }}">
			</div>
			<div class="form-group">
				<label for="drop">Drop</label>
				<input type="number" id="drop" class="form-control" name="drop" value="{{ $data->drops }}">
			</div>
			<div class="form-group">
				<label for="storting">Storting</label>
				<input type="number" id="storting" class="form-control hitung" name="storting" value="{{ $data->storting }}">
			</div>
	{{-- 		<div class="form-group">
				<label for="psp">PSP</label>
				<input type="number" id="psp" class="form-control hitung" name="psp" value="{{ $data->psp }}">
			</div> --}}
			<div class="form-group">
				<label for="tkp">TKP</label>
				<input type="number" id="tkp" class="form-control bg-white" name="tkp" readonly value="{{ $data->tkp }}">
			</div>
			<div class="form-group">
				<label for="drop_tunda">Drop Tunda</label>
				<input type="number" id="drop_tunda" class="form-control" name="drop_tunda" value="{{ $data->drop_tunda }}">
			</div>
			<div class="form-group">
				<label for="storting_tunda">Storting Tunda</label>
				<input type="number" id="storting_tunda" class="form-control" name="storting_tunda" value="{{ $data->storting_tunda }}">
			</div>
{{-- 			<div class="form-group">
				<label for="sisa_kas">Sisa Kas</label>
				<input type="number" id="sisa_kas" class="form-control" name="sisa_kas" value="{{ $data->sisa_kas }}">
			</div> --}}
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>

			</div>
		</form>
	</div>
</div>

@endsection
