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
	function getGraphic(target){
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});
		$.ajax({
			{{-- url: "{{ url()->current() }}?startdate="+startDate+"&enddate="+endDate+"&graphic="+target, --}}
			url: "{{ url()->current() }}?graphic="+target,
			type: "post",
			datatype: "html"
		}).done(function(data){
			Swal.fire({title: 'Selesai', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
			$("#"+target).empty().html(data);
			$('[data-toggle="tooltip"]').tooltip();
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			Swal.fire({html: 'No response from server', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 10000, timerProgressBar: true,});
		});
	}
	
	$(document).ready(function () {
		// Swal.fire({title: 'Memuat data..', icon: 'info', toast: true, position: 'top-end', showConfirmButton: false, timer: 0, timerProgressBar: true,});

	});
</script>
@endsection
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header row">
		<div class="ml-auto">
			<button class="btn btn-success"> Print</button>
		</div>
	</div>
</div>
<div class="card card-primary card-outline card-outline-tabs">
	<div class="card-header p-0 border-bottom-0">
		<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Grafik</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tabel</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Pencapaian</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Perbandingan</a>
			</li>
		</ul>
	</div>
	<div class="card-body">
		<div class="tab-content" id="custom-tabs-four-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
				<div id="tab-grafik row">
					<div class="col-md-8 m-auto">
					@includeIf('backend.perkembangan.global.global_chart')
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
				<div id="tab-grafik row">
					<div class="col-md-12 m-auto">
						@includeIf('backend.perkembangan.global.table')
					</div>
				</div> 
			</div>
			<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
				Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna. 
			</div>
			<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
				Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
			</div>
		</div>
	</div>
	<!-- /.card -->
</div>
@endsection