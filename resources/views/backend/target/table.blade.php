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
					@php
					// $jumlahLalu = $jumlahLama = $jumlahBaru = 0;
					@endphp
					@forelse ($data as $key => $val)
					<tr>
							{{-- <td class="text-center">{{ 'Ke - '. $val->count() }}</td> --}}
							<td>{{ $key }}</td>
							@foreach($val as $v)
							@php
								$anggota_lalu = $v['anggota_lalu'];
								$anggota_lama = $v['anggota_lama'];
								$anggota_baru = $v['anggota_baru'];
								$anggota_out = $v['anggota_out'];
								$anggota_kini = $v['anggota_kini'];
								$target_lalu = $v['target_lalu'];
								$target_20_drop = $v['target_20_drop'];
								$target_20_plnsn = $v['target_20_plnsn'];
								$target_kini = $v['target_kini'];
								$sekarang = $anggota_lama -   $anggota_baru +  $anggota_out;
								$resort_id = $v['resort_id'];
								$lalu = $val->sum('anggota_lalu') + $val->sum('anggota_lama') +  $val->sum('anggota_baru') - $val->sum('anggota_out') - $sekarang;
								$kini = $val->sum('anggota_lalu') + $val->sum('anggota_lama') +  $val->sum('anggota_baru') - $val->sum('anggota_out');
								$targetLalu = $val->sum('target_20_drop') -  $val->sum('target_20_plnsn') - $target_20_drop +  $target_20_plnsn;
								$targetKini = $val->sum('target_20_drop') -  $val->sum('target_20_plnsn');
							@endphp
							@endforeach
							<td class="text-right">{{ number_format($lalu) }}</td>
							<td class="text-right">{{ number_format($anggota_lama) }}</td>
							<td class="text-right">{{ number_format($anggota_baru) }}</td>
							<td class="text-right">{{ number_format($anggota_out) }}</td>
							<td class="text-right">{{ number_format($kini) }}</td>
							<td class="text-right">{{ number_format($targetLalu) }}</td>
							<td class="text-right">{{ number_format($target_20_drop) }}</td>
							<td class="text-right">{{ number_format($target_20_plnsn) }}</td>
							<td class="text-right">{{ number_format($targetKini) }}</td>
							<td><a class="btn btn-info btn-sm" href="{{ action('TargetController@show', $resort_id) }}" >Detail</a></td>
							@php
							$jumlahLalu[] = $lalu;
							$jumlahLama[] = $anggota_lama;
							$jumlahBaru[] = $anggota_baru;
							$jumlahOut[] = $anggota_out;
							$jumlahKini[] = $kini;
							$jumlahTargetLalu[] = $targetLalu;
							$jumlah20Drop[] = $target_20_drop;
							$jumlah20Plnsn[] = $target_20_plnsn;
							$jumlahTargetKini[] = $targetKini;
							@endphp

					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
					</tr>
					@endforelse
					@if(count($data) > 0)
					<tr class="text-bold">
						<td>Jumlah</td>
						<td class="text-right">{{ number_format(array_sum($jumlahLalu)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahLama)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahBaru)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahOut)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahKini)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTargetLalu)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlah20Drop)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlah20Plnsn)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTargetKini)) }}</td>
						<td></td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
</div>