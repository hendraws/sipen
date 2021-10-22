<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				{{-- <h6>Tanggal : {{date_format(date_create_from_format('Y-m-d', $getTanggal), 'd F Y')}}</h6> --}}
			</div>
			<div class="col-md-6">
				{{-- <h6 class="float-right">Pasaran : Senin - Kamis</h6> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="4">PERKEMBANGAN DROP</th>
						<th scope="col" colspan="4">PERBANDINGAN BULAN LALU</th>
						<th scope="col" rowspan="2" class="align-middle"></th>
					</tr>
					<tr class="text-center">
						<th scope="col">LALU</th>
						<th scope="col">KINI</th>
						<th scope="col">BERJALAN</th>
						<th scope="col">TOTAL</th>
						<th scope="col">BERJALAN</th>
						<th scope="col">EVALUASI</th>
						<th scope="col">TOTAL</th>
						<th scope="col">EVALUASI</th>
						<th scope="col">Kini</th>
					</tr>
				</thead>
				<tbody>
					@php
						$dropLalu = $dropKini = $dropBerjalan = $dropTotal = 0;	
					@endphp
					@forelse ($data as $key => $val)
					<tr>
						<td>{{ $key }}</td>
						@foreach($val as $v)

						@php
						$dropLalu = $dropBerjalan;
						$dropKini = $v['drop_kini'];
						$dropBerjalan = $dropLalu + $v['drop_kini'];
						$dropTotal = $v['total'];	
						@endphp
						@endforeach
						<td>{{ $val->sum('drop_kini') - $dropKini  }}</td>
						<td>{{ $dropKini }}</td>
						<td>{{ $val->sum('drop_kini') }}</td>
						<td>{{ $dropTotal }}</td>
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