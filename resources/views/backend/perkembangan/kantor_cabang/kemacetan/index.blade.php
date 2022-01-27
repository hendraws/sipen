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
					@php $jumlahSirkulasiMacet =  $evaluasiMacet = [] @endphp
					@forelse($groupKemacetan as $resort => $data)
					
					@php
					$ma_anggota = $ma_pinjaman = $ma_target = $ma_saldo = 0;
					$mb_anggota = $mb_pinjaman = $mb_target = $mb_saldo = 0;
					@endphp
					<tr class="bg-warning"><td colspan="11"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ optional($val->getPasaran)->hari  }} </td>
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
					@php
					$jumlahSirkulasiMacet['ma_anggota'][] = $ma_anggota; 
					$jumlahSirkulasiMacet['ma_pinjaman'][] = $ma_pinjaman; 
					$jumlahSirkulasiMacet['ma_target'][] = $ma_target; 
					$jumlahSirkulasiMacet['ma_saldo'][] = $ma_saldo; 
					$jumlahSirkulasiMacet['mb_anggota'][] = $mb_anggota; 
					$jumlahSirkulasiMacet['mb_pinjaman'][] = $mb_pinjaman; 
					$jumlahSirkulasiMacet['mb_target'][] = $mb_target; 
					$jumlahSirkulasiMacet['mb_saldo'][] = $mb_saldo; 
					$jumlahSirkulasiMacet['jumlah'][] = $ma_saldo+$mb_saldo; 
					@endphp
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse

					@if(count($groupKemacetan) >0)
					<tr class="bg-danger">
						<th colspan="2" class="text-center"><b>Jumlah</b></th>
						<th class="text-right">{{ array_sum($jumlahSirkulasiMacet['ma_anggota']) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['ma_pinjaman'])) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['ma_target'])) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['ma_saldo'])) }}</th>
						<th class="text-right">{{ array_sum($jumlahSirkulasiMacet['mb_anggota']) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['mb_pinjaman'])) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['mb_target'])) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['mb_saldo'])) }}</th>
						<th class="text-right">{{ number_format(array_sum($jumlahSirkulasiMacet['jumlah'])) }}</th>
					</tr>
					@endif
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
						<th scope="col">Anggota</th>
						<th scope="col">Anggota Keluar</th>
						<th scope="col" class="bg-gray-dark">Anggota Kini</th>
						<th scope="col">Saldo Macet</th>
						<th scope="col">Angsuran Masuk</th>
						<th scope="col" class="bg-gray-dark">Macet Kini</th>
					</tr>
				</thead>
				<tbody>
					@forelse($evaluasiBerjalan as $resort => $data)
					@php
					$anggota = $anggota_keluar = $anggota_kini =  0;
					$saldo_macet = $angsuran_masuk = $macet_kini = 0;
					@endphp
					<tr class="bg-warning"><td colspan="8"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						@if($loop->index == 0)
						<td rowspan="3" class="align-middle text-center"> {{ $data->sum('hk') }} </td>
						@endif
						<td class="text-center"> {{ $val->hari  }} </td>
						<td class="text-center"> {{ $val->anggota  }} </td>
						<td class="text-center"> {{ $val->anggota_keluar  }} </td>
						<td class="text-center bg-gray-dark"> {{ $val->anggota - $val->anggota_keluar  }} </td>
						<td> {{ number_format($val->total_ma_saldo + $val->total_mb_saldo)  }} </td>
						<td> {{ number_format($val->jml_angsuran)  }} </td>
						<td class="bg-gray-dark"> {{ number_format($val->total_ma_saldo + $val->total_mb_saldo - $val->jml_angsuran)  }} </td>
					</tr>
					@php
					$anggota += $val->anggota;
					$anggota_keluar += $val->anggota_keluar ;
					$anggota_kini +=  $val->anggota - $val->anggota_keluar;
					$saldo_macet += $val->total_ma_saldo + $val->total_mb_saldo;
					$angsuran_masuk += $val->jml_angsuran;
					$macet_kini +=$val->total_ma_saldo + $val->total_mb_saldo - $val->jml_angsuran;
					@endphp
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
					<tr class="text-right bg-success">
						<td colspan="2" class="align-middle text-center"> TOTAL </td>
						<td class="text-center"> {{ $anggota  }} </td>
						<td class="text-center"> {{ $anggota_keluar  }} </td>
						<td class="text-center"> {{ $anggota_kini  }} </td>
						<td> {{ number_format($saldo_macet)  }} </td>
						<td> {{ number_format($angsuran_masuk)  }} </td>
						<td class=""> {{ number_format($macet_kini)  }} </td>
					</tr>

					@php
					$evaluasiMacet['anggota'][] = $anggota;
					$evaluasiMacet['anggota_keluar'][] = $anggota_keluar;
					$evaluasiMacet['anggota_kini'][] = $anggota_kini;
					$evaluasiMacet['saldo_macet'][] = $saldo_macet;
					$evaluasiMacet['angsuran_masuk'][] = $angsuran_masuk;
					$evaluasiMacet['macet_kini'][] = $macet_kini;
					@endphp
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
					@if(count($evaluasiBerjalan) >0)
					<tr class="text-right bg-danger">
						<td colspan="2" class="align-middle text-center"> Jumlah </td>
						<td class="text-center"> {{ array_sum($evaluasiMacet['anggota'])  }} </td>
						<td class="text-center"> {{ array_sum($evaluasiMacet['anggota_keluar'])  }} </td>
						<td class="text-center"> {{ array_sum($evaluasiMacet['anggota_kini'])  }} </td>
						<td> {{ number_format(array_sum($evaluasiMacet['saldo_macet']))  }} </td>
						<td> {{ number_format(array_sum($evaluasiMacet['angsuran_masuk']))  }} </td>
						<td class=""> {{ number_format(array_sum($evaluasiMacet['macet_kini']))  }} </td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<hr>
</div>

<div class="card card-maroon card-outline">
	<div class="card-body">
		<h5>Grafik Angsuran Kemacetan</h5>
		<div class="row">
			<div class="col">
				<canvas id="grafikKemacetan"></canvas>
			</div>
		</div>
	</div>
	<hr>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var labelGrafik  = <?= $labelGrafik ?>;
		var dataGrafik  = <?= $dataGrafik ?>;
		const data = {
			labels: labelGrafik,
			datasets: dataGrafik,
		};
		const config = {
			type: 'line',
			data,
			options: {
				elements: {
					line: {
						tension: 0,
						fill: false
					}
				},
				plugins: {
					colorschemes: {
						scheme: 'brewer.Paired12'
					}
				},
				tooltips: {
					mode: 'index',
					bodySpacing : 10,
					callbacks: {
						label: function(tooltipItem, data) {
                        	// console.log(tooltipItem);
                        	return 'Rp.'+number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        };
        var perbandinganDrop = new Chart(
        	$('#grafikKemacetan'),
        	config
        	);

    });
</script>