@extends('layouts.app_master')
@section('title', 'Angsuran Kemacetan ')
@section('content-title', 'Angsuran Kemacetan Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
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
			format: "yyyy/mm",
			startView: "months", 
			minViewMode: "months"
		});
		$("#tanggal").datepicker( {
			format: "yyyy-mm-dd",
		}).on('changeDate', function(ev){
			getPasaran($(this).val());
		});
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
	$(document).on('keyup', '#pinjaman', function(){
		var pinjaman = $(this).val();
		var target = (pinjaman / 100) * 20;
		$('#target').val( target );

	});
	

</script>
@endsection

@section('content')
<div class="card card-outline card-primary">
	<div class="card-header">
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body" >
		<h5>Angsuran Kemacetan Cabang {{ ucfirst(optional(optional(auth()->user())->getCabang)->cabang) }}</h5>
		<form action="{{ action('AngsuranKemacetanController@update', $angsuran_kemacetan) }}" method="POST">
			@csrf
			@method('PUT')
			<div class="form-group row">
				<label for="resort" class="col-sm-2 col-form-label">Resort</label>
				<div class="col-md-10">
					<select class="form-control" name="resort_id" required readonly disabled="">
						<option disabled="" selected>Pilih Resort</option>
						@foreach ($resort as $row)
						<option value="{{ $row->id }}" {{ $angsuran_kemacetan->resort_id == $row->id ? 'selected' : '' }} >{{ $row->nama }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
				<div class="col-md-10">
					<input required type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="{{ $angsuran_kemacetan->tanggal }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="pinjaman" class="col-sm-2 col-form-label">Angsuran</label>
				<div class="col-md-10">
					<input  required type="number" id="pinjaman" class="form-control hitung" name="angsuran" value="{{ $angsuran_kemacetan->angsuran}}">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_anggota" class="col-sm-2 col-form-label">Anggota Keluar</label>
				<div class="col-md-10">
					<input required type="number" id="ma_anggota" class="form-control" name="anggota_keluar" value="{{ $angsuran_kemacetan->anggota_keluar }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="pasaran" class="col-sm-2 col-form-label">Pasaran</label>
				<div class="col-md-10">
					<select class="form-control" name="pasaran" readonly id="pasaran"> 
						@foreach($pasaran as $k => $v)
						<option value="{{ $k }}" selected>{{ $v }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<hr>
			<div class="modal-footer">
				<a href="{{ action('AngsuranKemacetanController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>
		
	</div>
	<!-- /.card-body -->
</div>


@endsection
