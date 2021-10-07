<div class="card card-success card-outline">
	<div class="card-body">
		<div class="table-responsive">
			<h5>Sirkulasi Macet</h5>
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" rowspan="2" class="align-middle">NO.</th>
						<th scope="col" rowspan="2" class="align-middle">PASARAN</th>
						<th scope="col" colspan="4">Macet Awal</th>
						<th scope="col" colspan="4">Macet Baru</th>
						<th scope="col"	rowspan="2" class="align-middle">JUMLAH</th>
						{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
					</tr>
					<tr>
						<th scope="col">ANGGOTA</th>
						<th scope="col">PINJAMAN</th>
						<th scope="col">TARGET</th>
						<th scope="col">SALDO</th>
						<th scope="col">ANGGOTA</th>
						<th scope="col">PINJAMAN</th>
						<th scope="col">TARGET</th>
						<th scope="col">SALDO</th>
					</tr>
				</thead>
				<tbody>
					@forelse($groupKemacetan as $resort => $data)
					@php
					$ma_anggota = $ma_pinjaman = $ma_target = $ma_saldo = 0;
					$mb_anggota = $mb_pinjaman = $mb_target = $mb_saldo = 0;
					@endphp
					<tr class="bg-warning"><td colspan="11"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ $val->getPasaran->hari  }} </td>
						<td> {{ $val->ma_anggota  }} </td>
						<td> {{ number_format($val->ma_pinjaman)  }} </td>
						<td> {{ number_format($val->ma_target)  }} </td>
						<td> {{ number_format($val->ma_saldo)  }} </td>
						<td> {{ $val->mb_anggota  }} </td>
						<td> {{ number_format($val->mb_pinjaman)  }} </td>
						<td> {{ number_format($val->mb_target)  }} </td>
						<td> {{ number_format($val->mb_saldo)  }} </td>
						<td>  {{ number_format($val->ma_saldo + $val->mb_saldo )  }} </td>
					</tr>
					@php
					$ma_anggota += $val->ma_anggota;
					$ma_pinjaman  += $val->ma_pinjaman;
					$ma_target  += $val->ma_target;
					$ma_saldo  += $val->ma_saldo;
					$mb_anggota  += $val->mb_anggota;
					$mb_pinjaman  += $val->mb_pinjaman;
					$mb_target  += $val->mb_target;
					$mb_saldo  += $val->mb_saldo;
					@endphp
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
					<tr class="bg-success">
						<td colspan="2" class="text-center"><b>Total</b></td>
						<td class="text-right">{{ $ma_anggota }}</td>
						<td class="text-right">{{ number_format($ma_pinjaman) }}</td>
						<td class="text-right">{{ number_format($ma_target) }}</td>
						<td class="text-right">{{ number_format($ma_saldo) }}</td>
						<td class="text-right">{{ $mb_anggota }}</td>
						<td class="text-right">{{ number_format($mb_pinjaman) }}</td>
						<td class="text-right">{{ number_format($mb_target) }}</td>
						<td class="text-right">{{ number_format($mb_saldo) }}</td>
						<td class="text-right">{{ number_format($ma_saldo+$mb_saldo) }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
	<hr>
</div>

<div class="card card-maroon card-outline">
	<div class="card-body">
		<div class="table-responsive">
			<h5>Evaluasi Macet Berjalan</h5>
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col">Hari Kerja</th>
						<th scope="col">PASARAN</th>
						<th scope="col">Saldo Macet</th>
						<th scope="col">Angsuran Masuk</th>
						<th scope="col">Macet Kini</th>
					</tr>
				</thead>
				<tbody>
					@forelse($evaluasiBerjalan as $resort => $data)
					<tr class="bg-warning"><td colspan="11"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						@if($loop->index == 0)
						<td rowspan="3" class="align-middle text-center"> {{ $val->hk }} </td>
						@endif
						<td class="text-center"> {{ $val->hari  }} </td>
						<td> {{ number_format($val->total_ma_saldo + $val->total_mb_saldo)  }} </td>
						<td> {{ number_format($val->jml_angsuran)  }} </td>
						<td> {{ number_format($val->total_ma_saldo + $val->total_mb_saldo - $val->jml_angsuran)  }} </td>
						<td>  </td>
					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
	<hr>
</div>