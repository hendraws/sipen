<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row mb-2">
			<div class="col-md-4">
				<div class="text-bold">
					Pasaran : {{ $psrn_name }}
				</div>
			</div>
			<div class="col-md-4 text-center">
				<div class="text-bold">
					Sisa Hari Kerja : {{ !empty($programKerja) ?  $programKerja->sisa_hk : 0 }}
				</div>
			</div>
			<div class="col-md-4">
				<button type="button" class="btn btn-danger btn-sm float-right " data-toggle="modal" data-target="#exampleModal">
					Setting Sisa Hari Kerja
				</button>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="5">SIMULASI PROGRAM KERJA</th>
					</tr>
					<tr class="text-center">
						<th scope="col">IP ST</th>
						{{-- <th scope="col">IP TKP</th> --}}
						<th scope="col">DROP / HK</th>
						<th scope="col">ST / HK</th>
						{{-- <th scope="col">TKP / HK</th> --}}
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					@php
					$sisa = $programKerja->sisa_hk != 0 ? $programKerja->sisa_hk : 1; 
					$programKerjaResort = !empty($programKerja) ?  $programKerja->drops / 6 : 0;
					$dropHk = ($programKerjaResort - $val->sum('drop_kini')) / $sisa;
					$stortingHk = ($programKerjaResort * (120 / 100))  - ($val->sum('storting_kini') / $sisa);
					@endphp
					<tr>
						<td>{{ $key }}</td>
						<td class="text-right">{{ number_format(round(($stortingHk / $dropHk) * 100, 2))  }} %</td>
						<td class="text-right">{{ number_format( round($dropHk) ) }}</td>
						<td class="text-right">{{ number_format( round($stortingHk) ) }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
					</tr>
					@endforelse

				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form action="{{ action('TargetController@storeHk') }}" method="POST" id="kantorCabangForm">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Setting Sisa Hari Kerja</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@csrf
					<div class="form-group row">
						<label for="cabang" class="col-sm-4 col-form-label">Set Sisa Hari Kerja</label>
						<div class="col-sm-12">
							<input required type="number" autocomplete="off" class="form-control" id="sisa_hk" value="{{ $programKerja->sisa_hk }}" name="sisa_hk">
						</div>
						<input type="hidden" name="program_kerja_id" value="{{ $programKerja->id  }}">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</div>
	</form>
</div>