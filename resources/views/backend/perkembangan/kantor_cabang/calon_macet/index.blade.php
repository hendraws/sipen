<div class="card card-success card-outline">
	<div class="card-body">
		<div class="table-responsive">
			<h5>Sirkulasi Calon Macet</h5>
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" rowspan="2" class="align-middle">NO.</th>
						<th scope="col" rowspan="2" class="align-middle">PASARAN</th>
						<th scope="col" colspan="4">CALON MACET </th>
						<th scope="col"	rowspan="2" class="align-middle">JUMLAH</th>
						{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
					</tr>
					<tr>
						<th scope="col">ANGGOTA</th>
						<th scope="col">PINJAMAN</th>
						<th scope="col">TARGET</th>
						<th scope="col">SALDO</th>
					</tr>
				</thead>
				<tbody>
					@forelse($groupCalonMacet as $resort => $data)
					@php
					$cma_anggota = $cma_pinjaman = $cma_target = $cma_saldo = 0;
					@endphp
					<tr class="bg-warning"><td colspan="11"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ $val->getPasaran->hari  }} </td>
						<td> {{ $val->cma_anggota  }} </td>
						<td> {{ number_format($val->cma_pinjaman)  }} </td>
						<td> {{ number_format($val->cma_target)  }} </td>
						<td> {{ number_format($val->cma_saldo)  }} </td>
						<td>  {{ number_format($val->cma_saldo)  }} </td>
					</tr>
					@php
					$cma_anggota += $val->cma_anggota;
					$cma_pinjaman  += $val->cma_pinjaman;
					$cma_target  += $val->cma_target;
					$cma_saldo  += $val->cma_saldo;
					@endphp
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
					<tr class="bg-success">
						<td colspan="2" class="text-center"><b>Total</b></td>
						<td class="text-right">{{ $cma_anggota }}</td>
						<td class="text-right">{{ number_format($cma_pinjaman) }}</td>
						<td class="text-right">{{ number_format($cma_target) }}</td>
						<td class="text-right">{{ number_format($cma_saldo) }}</td>
						<td class="text-right">{{ number_format($cma_saldo) }}</td>
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
			<h5>Evaluasi Calon Macet Berjalan</h5>
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col">Hari Kerja</th>
						<th scope="col">PASARAN</th>
						<th scope="col">Anggota</th>
						<th scope="col">Anggota Keluar</th>
						<th scope="col" class="bg-gray-dark">Anggota Kini</th>
						<th scope="col">Saldo Calon Macet</th>
						<th scope="col">Angsuran Masuk</th>
						<th scope="col" class="bg-gray-dark">Calon Macet Kini</th>
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
										{{-- {{ dd($val) }} --}}
					<tr class="text-right">
						@if($loop->index == 0)
						<td rowspan="3" class="align-middle text-center"> {{ $data->sum('hk') }} </td>
						@endif
						<td class="text-center"> {{ $val->hari  }} </td>
						<td class="text-center"> {{ $val->anggota ?? 0 }} </td>
						<td class="text-center"> {{ $val->anggota_keluar ?? 0  }} </td>
						<td class="text-center bg-gray-dark"> {{ $val->anggota - $val->anggota_keluar  }} </td>
						<td> {{ number_format($val->total_cma_saldo)  }} </td>
						<td> {{ number_format($val->jml_angsuran)  }} </td>
						<td class="bg-gray-dark"> {{ number_format($val->total_cma_saldo - $val->jml_angsuran)  }} </td>
					</tr>
					@php
					$anggota += $val->anggota;
					$anggota_keluar += $val->anggota_keluar ;
					$anggota_kini +=  $val->anggota - $val->anggota_keluar;
					$saldo_macet += $val->total_cma_saldo;
					$angsuran_masuk += $val->jml_angsuran;
					$macet_kini += $val->total_cma_saldo - $val->jml_angsuran;
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

<div class="card card-maroon card-outline">
	<div class="card-body">
		<h5>Grafik Angsuran Kemacetan</h5>
		<div class="row">
			<div class="col">
				<canvas id="grafikCalonMacet"></canvas>
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
        	$('#grafikCalonMacet'),
        	config
        	);

    });
</script>