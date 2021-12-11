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
						<th scope="col" colspan="4">Macet Awal</th>
						<th scope="col" colspan="4">Macet Baru</th>
						<th scope="col"	rowspan="2">JUMLAH</th>
						<th scope="col"	rowspan="2"></th>
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
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ optinal($val->getPasaran)->hari  }} </td>
						<td> {{ $val->ma_anggota  }} </td>
						<td> {{ $val->ma_pinjaman  }} </td>
						<td> {{ $val->ma_target  }} </td>
						<td> {{ $val->ma_saldo  }} </td>
						<td> {{ $val->mb_anggota  }} </td>
						<td> {{ $val->mb_pinjaman  }} </td>
						<td> {{ $val->mb_target  }} </td>
						<td> {{ $val->mb_saldo  }} </td>
						<td>  {{ $val->ma_saldo + $val->mb_saldo }}</td>
						<td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('KemacetanController@edit', $val)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger hapus ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KemacetanController@destroy',$val) }}">Hapus</a>
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