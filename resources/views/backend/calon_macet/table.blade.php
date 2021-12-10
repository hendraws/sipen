<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h4>Bulan : {{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h4>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" rowspan="2">NO.</th>
						<th scope="col" rowspan="2">PASARAN</th>
						<th scope="col" colspan="4">Calon Macet</th>
						<th scope="col"	rowspan="2"></th>
					</tr>
					<tr>
						<th scope="col">ANGGOTA</th>
						<th scope="col">PINJAMAN</th>
						<th scope="col">TARGET</th>
						<th scope="col">SALDO</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ $val->getPasaran->hari  }} </td>
						<td> {{ number_format($val->cma_anggota)  }} </td>
						<td> {{ number_format($val->cma_pinjaman)  }} </td>
						<td> {{ number_format($val->cma_target)  }} </td>
						<td> {{ number_format($val->cma_saldo)  }} </td>
						<td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('CalonMacetController@edit', $val)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger hapus ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('CalonMacetController@destroy',$val) }}">Hapus</a>
						</td>
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