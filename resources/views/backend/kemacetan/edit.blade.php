@extends('layouts.app_master')
@section('title', 'Kemacetan ')
@section('content-title', 'Kemacetan Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
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


	$(document).on('keyup', '#ma_pinjaman', function(){
		var pinjaman = $(this).val();
		var target = (pinjaman / 100) * 20;
		$('#ma_target').val( target );
		
	});


	$(document).on('keyup', '#mb_pinjaman', function(){
		var pinjaman = $(this).val();
		var target = (pinjaman / 100) * 20;
		$('#mb_target').val( target );
		
	});

</script>
@endsection

@section('content')
<div class="card card-body card-outline card-primary ">
<form action="{{ action('KemacetanController@update', $kemacetan) }}" method="POST" id="kemacetanForm">
			@csrf
			@method('PUT')
			<div class="form-group row">
				<label for="resort" class="col-sm-2 col-form-label">Resort</label>
				<div class="col-md-10">
					<select class="form-control" name="resort_id">
						<option disabled="" selected>Pilih Resort</option>
						@foreach ($resort as $row)
							<option value="{{ $row->id }}" {{ $kemacetan->resort_id == $row->id ? 'selected' : ''}} >{{ $row->nama }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<h5>Macet Awal</h5>
			<div class="form-group row">
				<label for="pasaran" class="col-sm-2 col-form-label">Set Pasaran</label>
				<div class="col-md-10">
					@php $pasaran = ['1'=>'Senin - Kamis','2'=>'Selasa - Jum\'at','3'=>'Rabu - Sabtu' ]@endphp
					<select class="form-control" name="pasaran">
						@foreach($pasaran as $k => $v)
						<option value="{{ $k }}" {{ $kemacetan->pasaran == $k ? 'selected' : ''}} >{{ $v }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_anggota" class="col-sm-2 col-form-label">Jumlah Anggota</label>
				<div class="col-md-10">
					<input type="number" id="ma_anggota" class="form-control" name="ma_anggota" value="{{ $kemacetan->ma_anggota }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="ma_pinjaman" class="form-control hitung" name="ma_pinjaman" value="{{ $kemacetan->ma_pinjaman }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="ma_target" class="form-control hitung" name="ma_target" readonly="" value="{{ $kemacetan->ma_target }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="ma_saldo" class="form-control" name="ma_saldo" value="{{ $kemacetan->ma_saldo }}">
				</div>
			</div>
			<hr>
			<h5>Macet Baru</h5>
			<div class="form-group row">
				<label for="mb_anggota" class="col-sm-2 col-form-label">Anggota</label>
				<div class="col-md-10">
					<input type="number" id="mb_anggota" class="form-control" name="mb_anggota" value="{{ $kemacetan->mb_anggota }}" >
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="mb_pinjaman" class="form-control hitung" name="mb_pinjaman" value="{{ $kemacetan->mb_pinjaman }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="mb_target" class="form-control hitung" name="mb_target" readonly="" value="{{ $kemacetan->mb_target }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="mb_saldo" class="form-control" name="mb_saldo" value="{{ $kemacetan->mb_saldo }}">
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ action('KemacetanController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>
</div>
@endsection


		