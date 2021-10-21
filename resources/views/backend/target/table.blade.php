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
						<th scope="col" colspan="5">Anggota</th>
						<th scope="col" colspan="4">Target Harian</th>
						<th scope="col" rowspan="2" class="align-middle"></th>
					</tr>
					<tr class="text-center">
						<th scope="col">Lalu</th>
						<th scope="col">Lama</th>
						<th scope="col">Baru</th>
						<th scope="col">Out</th>
						<th scope="col">Kini</th>
						<th scope="col">Lalu</th>
						<th scope="col">20% Drop</th>
						<th scope="col">20% Plsn</th>
						<th scope="col">Kini</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<?php $anggota_lalu  ?>
					<tr>
							{{-- <td class="text-center">{{ 'Ke - '. $val->count() }}</td> --}}
							<td>{{ $key }}</td>
							@foreach($val as $v)
							@php
								$anggota_lalu = $v->anggota_lalu;
								$anggota_lama = $v->anggota_lama;
								$anggota_baru = $v->anggota_baru;
								$anggota_out = $v->anggota_out;
								$anggota_kini = $v->anggota_kini;
								$target_lalu = $v->target_lalu;
								$target_20_drop = $v->target_20_drop;
								$target_20_plnsn = $v->target_20_plnsn;
								$target_kini = $v->target_kini;
								$sekarang = $anggota_lama -   $anggota_baru +  $anggota_out;
								$resort_id = $v->resort_id;
							@endphp
							@endforeach
							<td>{{ $val->sum('anggota_lalu') + $val->sum('anggota_lama') +  $val->sum('anggota_baru') - $val->sum('anggota_out') - $sekarang }}</td>
							<td>{{ $anggota_lama }}</td>
							<td>{{ $anggota_baru }}</td>
							<td>{{ $anggota_out }}</td>
							<td>{{ $val->sum('anggota_lalu') + $val->sum('anggota_lama') +  $val->sum('anggota_baru') - $val->sum('anggota_out') }}</td>
							<td>{{ $val->sum('target_20_drop') -  $val->sum('target_20_plnsn') - $target_20_drop +  $target_20_plnsn}}</td>
							<td>{{ $target_20_drop }}</td>
							<td>{{ $target_20_plnsn }}</td>
							<td>{{ $val->sum('target_20_drop') -  $val->sum('target_20_plnsn') }}</td>
							<td><a class="btn btn-info btn-sm" href="{{ action('TargetController@show', $resort_id) }}" target="_blank" >Detail</a></td>
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