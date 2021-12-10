@extends('layouts.app_master')
@section('title', 'Angsuran Calon Macet ')
@section('content-title', 'Angsuran Calon Macet Cabang '. ucfirst(optional(optional(auth()->user())->getCabang)->cabang))
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

	$(document).on('click', '#pinjaman', function(){
		var pinjaman = $(this).val();
		var target = (pinjaman / 100) * 20;
		$('#target').val( target );

	});
	
	$(document).on('click', '#filter', function(){
		var resort = $('#resort_id').val();
		var tanggal = $('#bulan').val();
		var url = "{{ url()->current() }}?tanggal="+tanggal+"&resort="+resort;
		if(resort == null){
			return Swal.fire({title: 'Pilih Resort Terlebih dahulu', icon: 'warning', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		}
		getDataTable(url, '#data-table')
	});

	$(document).on('click', '#cetak', function(){
		if($('#bulan').val() === ''){
			return Swal.fire({title: ' Silahkan Pilih Bulan terlebih dahulu', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		}

		if($('#resort_id').val() == null){
			return Swal.fire({title: ' Silahkan Pilih Resort terlebih dahulu', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true,});
		}
		var resort = $('#resort_id').val();
		var tanggal = $('#bulan').val();
		var url = "{{ url()->current() }}?tanggal="+tanggal+"&resort="+resort+"&cetak=cetak";
		getDataTable(url, '.allprint');
	});


	$(document).on('click','.hapus',function(e){
		e.preventDefault();
		var tag = $(this);
		var url = $(this).data('url');
		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text: "Data akan dihapus dan data tidak dapat dikembalikan lagi !",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Iya, Hapus!'
		}).then((result) => {
			if (result.value == true) {
				$.ajax({
					type:'DELETE',
					url:url,
					data:{
						"_token": "{{ csrf_token() }}",
					},
					success:function(data) {
						if (data.code == '200'){
							Swal.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
								);
							$(location).prop('href', '{{ url()->full() }}')
						}
					}
				});

			}
		})
	});
</script>
@endsection

@section('content')
<div class="allprint">
	<div class="card card-outline card-primary collapsed-card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-4">
					<h3 class="card-title">Input Data</h3>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="resort_id" id="resort_id">
						<option disabled="" selected>Pilih Resort</option>
						@foreach ($resort as $row)
						<option value="{{ $row->id }}" >{{ $row->nama }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-5 ml-auto">

					<div class="input-group mb-3 input-sm">
						<input type="text" class="form-control input-sm " placeholder="Pilih Bulan" readonly="" id="bulan" value="{{ date('Y/m') }}">
						<button class="btn btn-outline-info ml-2" type="button" id="filter">Filter</button>
						<button class="btn btn-success  mx-2 float-right" type="button" id="cetak">Cetak</button>
						<div class="card-tools ml-2">
							<button type="button" class="btn btn-primary" data-card-widget="collapse">Tambah
							</button>
						</div>
					</div>
				</div>
			</div>


			<!-- /.card-tools -->
		</div>
		<!-- /.card-header -->
		<div class="card-body" style="display: none;">
			@includeIf('backend.angsuran_calon_macet.create')
		</div>
		<!-- /.card-body -->
	</div>

	<div id="data-table"></div>

</div>
@endsection
