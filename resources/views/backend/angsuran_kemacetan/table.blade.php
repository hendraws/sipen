<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h4>Bulan : {{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h4>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" >Hari Kerja</th>
						<th scope="col" >Tanggal</th>
						<th scope="col" >Pasaran</th>
						<th scope="col" >Angsuran Kemacetan</th>
						<th scope="col" >Anggota Keluar</th>
						{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
						<td class="text-center"> {{ $loop->index +1 }} </td>
						<td class="text-center"> {{ $val->tanggal }} </td>
						<td class="text-center"> {{ optional($val->getPasaran)->hari  }} </td>
						<td class="text-right" width="20%"> {{ number_format($val->angsuran)  }} </td>
						<td class="text-center"> {{ $val->anggota_keluar  }} </td>
						{{-- <td>  </td> --}}
						<td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('AngsuranKemacetanController@edit', $val)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger hapus ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('AngsuranKemacetanController@destroy',$val) }}">Hapus</a>
						</td>
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
	<div class="card-footer">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table id="data-table" class="table table-sm table-bordered">
						<thead class="text-center">
							<tr class="text-center">
								<th scope="col" >Pasaran</th>
								<th scope="col" >Anggota</th>
								<th scope="col" >Anggota Keluar</th>
								<th scope="col" >Total Anggota</th>
								<th scope="col" >Macet Awal</th>
								<th scope="col" >Macet Baru</th>
								<th scope="col" >Total Macet</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
							</tr>
						</thead>
						<tbody>
							@php $total = []; @endphp
							@forelse ($kemacetan as $key => $val)
							<tr>
								<td class="text-center"> {{ optional($val->getPasaran)->hari  }} </td>
								<td class="text-right"> {{ $val->ma_anggota + $val->mb_anggota  }} </td>
								<td class="text-right"> {{ $val->anggota_keluar  }} </td>
								<td class="text-right"> {{ $val->ma_anggota + $val->mb_anggota -$val->anggota_keluar   }} </td>
								<td class="text-right"> {{ number_format($val->ma_saldo)  }} </td>
								<td class="text-right"> {{ number_format($val->mb_saldo)  }} </td>
								<td class="text-right"> {{ number_format($val->mb_saldo + $val->ma_saldo)  }} </td>
								<td class="text-right"> {{ number_format($val->angsuran ?? 0)  }} </td>
								<td class="text-right"> {{ number_format($val->mb_saldo + $val->ma_saldo - $val->angsuran)  }} </td>
							</tr>
							@php 
								$total['anggota'][] = $val->ma_anggota + $val->mb_anggota;
								$total['macetAwal'][] = $val->ma_saldo;
								$total['macetBaru'][] = $val->mb_saldo;
							@endphp
							@empty
							<tr>
								<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
							</tr>
							@endforelse
						</tr>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="col-md-12 mt-3 bg-dark">
				<h5>Total keseluruhan Berjalan</h5>
				<div class="table-responsive">
					<table id="data-table" class="table table-sm table-bordered">
						<thead class="text-center">
							<tr class="text-center">
								<th scope="col" >Hari Kerja</th>
								<th scope="col" >Anggota</th>
								<th scope="col" >Anggota Keluar</th>
								<th scope="col" >Total Anggota</th>
								<th scope="col" >Macet Awal</th>
								<th scope="col" >Macet Baru</th>
								<th scope="col" >Total Macet</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
								{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center"> {{ number_format($totalAngsuran->hk) }}</td>
								<td class="text-center"> {{ number_format(array_sum($total['anggota'])) }}</td>
								<td class="text-center"> {{ number_format($totalAngsuran->total_anggota_keluar) }}</td>
								<td class="text-center"> {{ number_format(array_sum($total['anggota']) - $totalAngsuran->total_anggota_keluar)  }}</td>
								<td class="text-center"> {{ number_format(array_sum($total['macetAwal'])) }}</td>
								<td class="text-center"> {{ number_format(array_sum($total['macetBaru'])) }}</td>
								<td class="text-center"> {{ number_format(array_sum($total['macetAwal']) + array_sum($total['macetBaru'])) }}</td>
								<td class="text-center"> {{ number_format($totalAngsuran->total_angsuran)  }}</td>
								<td class="text-center"> {{  number_format(array_sum($total['macetAwal']) + array_sum($total['macetBaru']) - $totalAngsuran->total_angsuran)  }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<hr>
</div>