@extends('layouts.app_master')
@section('title', 'Tambah Report')
@section('content-title', 'Tambah Report')
@section('css')
<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-body">
		<div class="form-group">
			<label for="inputName">Kantor Cabang</label>
			<select class="form-control custom-select">
				<option selected="" disabled="">Select one</option>
				<option>On Hold</option>
				<option>Canceled</option>
				<option>Success</option>
			</select>
		</div>
		<div class="form-group">
			<label for="inputClientCompany">Tanggal</label>
			<input type="text" id="inputClientCompany" class="form-control">
		</div>
		<div class="form-group">
			<label for="drop">Drop</label>
			<input type="text" id="drop" class="form-control" name="drop">
		</div>
		<div class="form-group">
			<label for="storting">Storting</label>
			<input type="text" id="storting" class="form-control" name="storting">
		</div>
		<div class="form-group">
			<label for="psp">Psp</label>
			<input type="text" id="psp" class="form-control" name="psp">
		</div>
		<div class="form-group">
			<label for="drop_tunda">Drop Tunda</label>
			<input type="text" id="drop_tunda" class="form-control" name="drop_tunda">
		</div>
		<div class="form-group">
			<label for="storting_tunda">Storting Tunda</label>
			<input type="text" id="storting_tunda" class="form-control" name="storting_tunda">
		</div>
		<div class="form-group">
			<label for="tkp">Tkp</label>
			<input type="text" id="tkp" class="form-control" name="tkp">
		</div>
		<div class="form-group">
			<label for="sisa_kas">Sisa Kas</label>
			<input type="text" id="sisa_kas" class="form-control" name="sisa_kas">
		</div>
	</div>
</div>

@endsection
