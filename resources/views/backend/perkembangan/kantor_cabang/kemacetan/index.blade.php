<div class="card card-success card-outline">
	<div class="card-body">
		<div class="table-responsive">
			<table id="data-table" class="table table-sm">
				<thead class="text-center">
					<tr class="text-center">
						<th scope="col" rowspan="2">NO.</th>
						<th scope="col" rowspan="2">PASARAN</th>
						<th scope="col" colspan="4">Macet Awal</th>
						<th scope="col" colspan="4">Macet Baru</th>
						<th scope="col"	rowspan="2">JUMLAH</th>
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
					<tr class="bg-warning"><td colspan="11"><b>Resort {{ ucfirst($resort) }}</b></td></tr>
					@forelse ($data as $key => $val)
					<tr class="text-right">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ $val->getPasaran->hari  }} </td>
						<td> {{ $val->ma_anggota  }} </td>
						<td> {{ $val->ma_pinjaman  }} </td>
						<td> {{ $val->ma_target  }} </td>
						<td> {{ $val->ma_saldo  }} </td>
						<td> {{ $val->mb_anggota  }} </td>
						<td> {{ $val->mb_pinjaman  }} </td>
						<td> {{ $val->mb_target  }} </td>
						<td> {{ $val->mb_saldo  }} </td>
						<td>  </td>
						{{-- <td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('KemacetanController@edit', $val->id)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KemacetanController@delete',$val->id) }}">Hapus</a>
						</td> --}}
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
	</div><!-- /.card-body -->
	<hr>
</div>