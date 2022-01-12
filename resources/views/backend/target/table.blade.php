<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="text-bold">
					Pasaran : {{ $psrn_name }}
				</div>
			</div>
			<div class="col-md-6">
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
					$target = $jumlah = [];
					
					// $jumlahLalu = $jumlahLama = $jumlahBaru = 0;
					@endphp
					@forelse ($data as $key => $val)
					{{-- {{ dd($val) }} --}}
					<?php $anggota_lalu = $target_lalu = 0;  ?>
					<tr>
							{{-- <td class="text-center">{{ 'Ke - '. $val->count() }}</td> --}}
							<td>{{ $key }}</td>
							@foreach($val as $v)
							@php
							if(!array_key_exists($key, $target)){
								$target[$key]['anggota_lalu'] = $v['anggota_lalu'];
								$target[$key]['anggota_lama'] = $v['anggota_lama'];
								$target[$key]['anggota_baru'] = $v['anggota_baru'];
								$target[$key]['anggota_out'] = $v['anggota_out'];
								$target[$key]['anggota_kini'] = $v['anggota_lalu'] + $v['anggota_lama'] +$v['anggota_baru']- $v['anggota_out'];
								$target[$key]['drop'] = $v['target_20_drop']; 
								$target[$key]['plnsn'] = $v['target_20_plnsn']; 
								$target[$key]['target_lalu'] = $targetLalu[$key];
								$target[$key]['target_kini'] = $targetLalu[$key] + $v['target_20_drop'] - $v['target_20_plnsn']; 

							}else{
								$target[$key]['anggota_lalu'] =  $target[$key]['anggota_kini'];
								$target[$key]['anggota_lama'] = $v['anggota_lama'];
								$target[$key]['anggota_baru'] = $v['anggota_baru'];
								$target[$key]['anggota_out'] = $v['anggota_out'];
								$target[$key]['anggota_kini'] = $target[$key]['anggota_lalu'] + $v['anggota_lama'] +$v['anggota_baru']- $v['anggota_out'];
								$target[$key]['drop'] = $v['target_20_drop']; 
								$target[$key]['plnsn'] = $v['target_20_plnsn']; 
								$target[$key]['target_lalu'] = $target[$key]['target_kini'];
								$target[$key]['target_kini'] = $target[$key]['target_lalu'] + $v['target_20_drop'] - $v['target_20_plnsn']; 
							}

								$resort_id = $v['resort_id'];
							@endphp
							@endforeach
								
							<td class="text-right">{{ number_format( $target[$key]['anggota_lalu']) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['anggota_lama'] ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['anggota_baru'] ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['anggota_out'] ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['anggota_kini']) }}</td>

							<td class="text-right">{{ number_format( $target[$key]['target_lalu']  ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['drop'] ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['plnsn'] ) }}</td>
							<td class="text-right">{{ number_format( $target[$key]['target_kini']   ) }}</td>
							<td><a class="btn btn-info btn-sm" href="{{ action('TargetController@show', $resort_id) }}" >Detail</a></td>
							@php
							$jumlah['anggota_lalu'][] = $target[$key]['anggota_lalu'];
							$jumlah['anggota_lama'][] = $target[$key]['anggota_lama'];
							$jumlah['anggota_baru'][] = $target[$key]['anggota_baru'];
							$jumlah['anggota_out'][] = $target[$key]['anggota_out'];
							$jumlah['anggota_kini'][] = $target[$key]['anggota_kini'];
							$jumlah['target_lalu'][] =$target[$key]['target_lalu'];
							$jumlah['drop'][] = $target[$key]['drop']; 
							$jumlah['plnsn'][] =  $target[$key]['plnsn'];
							$jumlah['target_kini'][] =  $target[$key]['target_kini'];
							// $jumlah['targer_lalu'][] = 
							// $jumlahLalu[] = $lalu;
							// $jumlahLama[] = $anggota_lama;
							// $jumlahBaru[] = $anggota_baru;
							// $jumlahOut[] = $anggota_out;
							// $jumlahKini[] = $kini;
							// $jumlahTargetLalu[] = $targetLalu;
							// $jumlah20Drop[] = $target_20_drop;
							// $jumlah20Plnsn[] = $target_20_plnsn;
							// $jumlahTargetKini[] = $targetKini;
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
						<td class="text-right">{{ number_format( array_sum($jumlah['anggota_lalu']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['anggota_lama']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['anggota_baru']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['anggota_out']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['anggota_kini']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['target_lalu']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['drop']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['plnsn']) ) }}</td>
						<td class="text-right">{{ number_format( array_sum($jumlah['target_kini']) ) }}</td>
				{{-- 		<td class="text-right">{{ number_format(array_sum($jumlahLama)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahBaru)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahOut)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahKini)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTargetLalu)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlah20Drop)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlah20Plnsn)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTargetKini)) }}</td> --}}
						<td></td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
</div>

{{-- 
							if(!array_key_exists($key, $target)){
								$target[$key]['anggota_lalu'] = $v['anggota_lalu'];
								$target[$key]['anggota_lama'][] = $v['anggota_lama']; 
								$target[$key]['anggota_baru'][] = $v['anggota_baru']; 
								$target[$key]['anggota_out'][] = $v['anggota_out']; 
								$target[$key]['anggota_kini'][] = $v['anggota_lama'] + $v['anggota_baru'] - $v['anggota_out']; 
								$anggota_lalu = $v['anggota_lalu'] + $v['anggota_lama'] + $v['anggota_baru'] - $v['anggota_out'];

								$target[$key]['drop'][] = $v['target_20_drop']; 
								$target[$key]['plnsn'][] = $v['target_20_plnsn']; 
								$target[$key]['target_kini'][] = $v['target_20_drop'] - $v['target_20_plnsn']; 
								$target_lalu = $v['target_20_drop'] - $v['target_20_plnsn'];
							}else{
								// $target[$key]['anggota_lalu'] = $anggota_lalu;
								// dd($anggota_lalu, $target[$key]['anggota_lalu']);
								$target[$key]['anggota_lama'][] = $v['anggota_lama']; 
								$target[$key]['anggota_baru'][] = $v['anggota_baru']; 
								$target[$key]['anggota_out'][] = $v['anggota_out']; 
								$target[$key]['anggota_kini'][] = $v['anggota_lama'] + $v['anggota_baru'] - $v['anggota_out']; 
								$anggota_lalu +=  $v['anggota_lama'] + $v['anggota_baru'] - $v['anggota_out'];

								$target[$key]['target_lalu'][] = $target_lalu;
								$target[$key]['drop'][] = $v['target_20_drop']; 
								$target[$key]['plnsn'][] = $v['target_20_plnsn']; 
								$target[$key]['target_kini'][] = $v['target_20_drop'] - $v['target_20_plnsn']; 
								$target_lalu += $v['target_20_drop'] - $v['target_20_plnsn'];

							} --}}