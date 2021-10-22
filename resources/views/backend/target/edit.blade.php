@extends('layouts.app_master')
@section('title', 'Target Resort '.$data->getResort->nama)
@section('content-title', 'Edit Target Resort '. $data->getResort->nama)
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
	$("#tanggal").datepicker( {
		format: "yyyy-mm-dd",
	}).on('changeDate', function(ev){
		getPasaran($(this).val());
	});
</script>
@endsection

@section('content')
<div class="card card-lightblue card-body">
	{{-- <h5>Angsuran Kemacetan Cabang {{ ucfirst(optional(optional(auth()->user())->getCabang)->cabang) }}</h5> --}}
<form action="{{ action('TargetController@update', $data->id) }}" method="POST">
	@csrf
	@method('put')
	<div class="form-group row">
		<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
		<div class="col-md-10">
			<input required type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="{{ $data->tanggal }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="drop" class="col-sm-2 col-form-label">Drop</label>
		<div class="col-md-10">
			<input  required type="number" id="drop" class="form-control hitung" name="target_drops" value="{{ $data->target_drops }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="storting" class="col-sm-2 col-form-label">Storting</label>
		<div class="col-md-10">
			<input  required type="number" id="storting" class="form-control hitung" name="storting_kini" value="{{ $data->storting_kini }}" >
		</div>
	</div>	
	<div class="form-group row">
		<label for="pelunasan" class="col-sm-2 col-form-label">Pelunasan</label>
		<div class="col-md-10">
			<input  required type="number" id="pelunasan" class="form-control hitung" name="target_plnsn" value="{{ $data->target_plnsn }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="anggota_lama" class="col-sm-2 col-form-label">Anggota Lama</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_lama" class="form-control" name="anggota_lama" value="{{ $data->anggota_lama }}">
		</div>
	</div>	
	<div class="form-group row">
		<label for="anggota_baru" class="col-sm-2 col-form-label">Anggota Baru</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_baru" class="form-control" name="anggota_baru" value="{{ $data->anggota_baru }}">
		</div>
	</div>	
	<div class="form-group row">
		<label for="anggota_keluar" class="col-sm-2 col-form-label">Anggota Keluar</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_keluar" class="form-control" name="anggota_out" value="{{ $data->anggota_out }}">
		</div>
	</div>	
	<div class="form-group row">
		<label for="pasaran" class="col-sm-2 col-form-label">Pasaran</label>
		<div class="col-md-10">
			<select class="form-control" name="pasaran" readonly id="pasaran"> 
				<option value="{{ $data->pasaran }}" selected >{{ $data->getPasaran->hari }}</option>
			</select>
		</div>
	</div>
	<hr>
	<input type="hidden" name="resort_id" value="{{ $data->resort_id }}">
	<div class="modal-footer">
		<a href="{{ action('TargetController@index') }}" class="btn btn-secondary">Kembali</a>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>
	</div>
</form>
</div>
@endsection
