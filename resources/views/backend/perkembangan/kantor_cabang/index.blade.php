@extends('layouts.app_master')
@section('title', 'Perkembangan')
@section('content-title', 'Informasi Perkembangan KSP Satria Mulia Arthomoro')
@section('css')
@endsection
@section('js')
<script src="{{ asset('vendors/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-colorschemes.js') }}"></script>
<script src="{{ asset('vendors/chartjs/chartjs-plugin-datalabels.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script type="text/javascript">
	$('body').addClass('sidebar-mini sidebar-collapse');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function number_format(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}
	function getData(cabang){
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		$.ajax({
			{{-- url: "{{ url()->current() }}?startdate="+startDate+"&enddate="+endDate+"&graphic="+target, --}}
			url: "{{ url()->current() }}?cabang="+cabang,
			type: "post",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#dataCabang").empty().html(data);
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}
	
	$(document).ready(function () {
		$('#cabang').on('change', function() {
			Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
			getData(this.value);
		});	
		if($('#cabang').val().length != 0)
		{
			getData($('#cabang').val());
		}
	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header row">
		<div class="col-md-8">
			<div class="form-group row">
				<label for="tanggal" class="col-sm-2 col-form-label">Pilih Cabang</label>
				<div class="col-md-6">

					<select class="form-control custom-select" id="cabang" name="cabang">
						<option selected="" disabled="">Pilih Cabang</option>
						@foreach ($cabang as $key => $val)
						<option value="{{ $key }}" {{ auth()->user()->cabang_id == $key ? 'selected' : ''}}>{{ $val }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="ml-auto">
			<button class="btn btn-success"> Print</button>
		</div>
	</div>
</div>
<div id="dataCabang"></div>
@endsection