@extends('layouts.app_master')
@section('title', 'Calon Macet ')
@section('content-title', 'Calon Macet Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
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


	$(document).on('keyup', '#pinjaman', function(){
		var pinjaman = $(this).val();
		var target = (pinjaman / 100) * 20;
		$('#target').val( target );

	});
	


</script>
@endsection

@section('content')
<div class="card card-outline card-primary card-body">

		<form action="{{ action('CalonMacetController@update', $calonMacet) }}" method="POST" id="kemacetanForm">
			@csrf
			@method('PUT')
			<div class="form-group row">
				<label for="resort" class="col-sm-2 col-form-label">Resort</label>
				<div class="col-md-10">
					<select class="form-control" name="resort_id">
						<option disabled="" selected>Pilih Resort</option>
						@foreach ($resort as $row)
							<option value="{{ $row->id }}" {{ $calonMacet->resort_id == $row->id ? 'selected' : '' }} >{{ $row->nama }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<h5>Calon Macet</h5>
			<div class="form-group row">
				<label for="pasaran" class="col-sm-2 col-form-label">Set Pasaran</label>
				<div class="col-md-10">
					@php $pasaran = ['1'=>'Senin - Kamis','2'=>'Selasa - Jum\'at','3'=>'Rabu - Sabtu' ]@endphp
					<select class="form-control" name="pasaran">
						@foreach($pasaran as $k => $v)
						<option value="{{ $k }}" {{ $calonMacet->pasaran_id == $k ? 'selected' : ''}} >{{ $v }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_anggota" class="col-sm-2 col-form-label">Jumlah Anggota</label>
				<div class="col-md-10">
					<input type="number" id="ma_anggota" class="form-control" name="cma_anggota" value="{{ $calonMacet->cma_anggota }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="pinjaman" class="form-control hitung" name="cma_pinjaman" value="{{ $calonMacet->cma_pinjaman }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="target" class="form-control hitung" name="cma_target" readonly="" value="{{ $calonMacet->cma_target }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="saldo" class="form-control" name="cma_saldo" value="{{ $calonMacet->cma_saldo }}">
				</div>
			</div>
			<hr>
			<div class="modal-footer">
				<a href="{{ action('CalonMacetController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>
	<!-- /.card-body -->
</div>

<div id="data-table"></div>

@endsection
