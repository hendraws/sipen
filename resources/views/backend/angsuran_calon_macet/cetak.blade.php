<div class="card card-success card-outline">
	<div class="card-header">
		<h4>Angsuran Calon Macet</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-3">Cabang</div>
			<div class="col-9">: {{ ucfirst(auth()->user()->getCabang->cabang)  }}</div>
			<div class="col-3">Resort</div>
			<div class="col-9">: <h7>{{ ucfirst($data->first()->getResort->nama)  }}</h7></div>
			<div class="col-3">Bulan</div>
			<div class="col-9">: <h7>{{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h7></div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" >NO.</th>
						<th scope="col" >Pasaran</th>
						<th scope="col" >Angsuran Calon Macet</th>
						<th scope="col" >Anggota Keluar</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
						<td class="text-center"> {{ $loop->index +1 }} </td>
						<td class="text-center"> {{ $val->getPasaran->hari  }} </td>
						<td class="text-right"> {{ number_format($val->angsuran)  }} </td>
						<td class="text-center"> {{ $val->anggota_keluar  }} </td>
						{{-- <td>  </td> --}}
						
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
								<th scope="col" >Calon Macet Awal</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
							</tr>
						</thead>
						<tbody>
							@php $total = []; @endphp
							@forelse ($calonMacet as $key => $val)
							<tr>
								<td class="text-center"> {{ optional($val->getPasaran)->hari  }} </td>
								<td class="text-right"> {{ number_format($val->cma_anggota)  }} </td>
								<td class="text-right"> {{ number_format($val->anggota_keluar)  }} </td>
								<td class="text-right"> {{ number_format($val->cma_saldo)  }} </td>
								<td class="text-right"> {{ number_format($val->angsuran) ?? 0  }} </td>
								<td class="text-right"> {{ number_format($val->cma_saldo - $val->angsuran)  }} </td>
							</tr>
							@php 
								$total['anggota'][] = $val->cma_anggota;
								$total['calonMacet'][] = $val->cma_saldo;
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
			<div class="col-md-12 mt-3 ">
				<h5>Total keluruhan Berjalan</h5>
				<div class="table-responsive">
					<table id="data-table" class="table table-sm table-bordered">
						<thead class="text-center">
							<tr class="text-center">
								<th scope="col" >Hari Kerja</th>
								<th scope="col" >Anggota</th>
								<th scope="col" >Anggota Keluar</th>
								<th scope="col" >Total Anggota</th>
								<th scope="col" >Calon Macet Awal</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>{{ $totalAngsuran->hk }}</td>
								<td>{{ number_format(array_sum($total['anggota'])) }}</td>
								<td>{{ number_format($totalAngsuran->total_anggota_keluar) }}</td>
								<td><b>{{ number_format(array_sum($total['anggota']) - $totalAngsuran->total_anggota_keluar) }}</b></td>
								<td class="text-right">{{ number_format(array_sum($total['calonMacet'])) }}</td>
								<td class="text-right">{{ number_format($totalAngsuran->total_angsuran) }}</td>
								<td class="text-right"><b>{{ number_format(array_sum($total['calonMacet']) - $totalAngsuran->total_angsuran) }}</b></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<hr>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		setTimeout(function(){ window.print() }, 2000);
	})
</script>