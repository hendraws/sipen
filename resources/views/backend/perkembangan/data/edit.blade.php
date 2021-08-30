@extends('layouts.app_master')
@section('title', 'Perkembangan Kerja')
@section('content-title', 'Edit Perkembangan Kerja')
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
		<form action="{{ action('PerkembanganController@update', $data->id) }}" method="POST" id="kantorCabangForm">
			@csrf
			@method('PATCH')

			<div class="form-group row">
				<label for="drop" class="col-sm-2 col-form-label">Kantor Cabang</label>
				<div class="col-md-10">
					<input type="text" id="tanggal" class="form-control tanggal" readonly autocomplete="off" value="{{optional($data->Cabang)->cabang }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop" class="col-sm-2 col-form-label">Tanggal</label>
				<div class="col-md-10">
					<input type="text" id="tanggal" class="form-control tanggal" name="tanggal" readonly autocomplete="off" value="{{ $data->tanggal }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop" class="col-sm-2 col-form-label">Drop</label>
				<div class="col-md-10">
					<input type="number" id="drop" class="form-control" name="drop" value="{{ $data->drops }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="storting" class="col-sm-2 col-form-label">Storting</label>
				<div class="col-md-10">
					<input type="number" id="storting" class="form-control hitung" name="storting" value="{{ $data->storting }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="psp" class="col-sm-2 col-form-label">PSP</label>
				<div class="col-md-10">
					<input type="number" id="psp" class="form-control hitung" name="psp" value="{{ $data->psp }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop_tunda" class="col-sm-2 col-form-label">Drop Tunda</label>
				<div class="col-md-10">
					<input type="number" id="drop_tunda" class="form-control" name="drop_tunda" value="{{ $data->drop_tunda }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="storting_tunda" class="col-sm-2 col-form-label">Storting Tunda</label>
				<div class="col-md-10">
					<input type="number" id="storting_tunda" class="form-control" name="storting_tunda" value="{{ $data->storting_tunda }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="tkp" class="col-sm-2 col-form-label">TKP</label>
				<div class="col-md-10">
					<input type="number" id="tkp" class="form-control bg-white" name="tkp" readonly value="{{ $data->tkp }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="sisa_kas" class="col-sm-2 col-form-label">Sisa Kas</label>
				<div class="col-md-10">
					<input type="number" id="sisa_kas" class="form-control" name="sisa_kas" value="{{ $data->sisa_kas }}">
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>

			</div>
		</form>
	</div>
</div>

@endsection
