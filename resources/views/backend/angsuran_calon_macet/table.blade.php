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
						<th scope="col" rowspan="2">Pasaran</th>
						<th scope="col" colspan="4">Angsuran Kemacetan</th>
						{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
						<td class="text-center"> {{ $loop->index +1 }} </td>
						<td class="text-center"> {{ $val->getPasaran->hari  }} </td>
						<td class="text-center"> {{ $val->angsuran  }} </td>
						{{-- <td>  </td> --}}
						{{-- <td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('KemacetanController@edit', $val->id)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KemacetanController@delete',$val->id) }}">Hapus</a>
						</td> --}}
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
					<table id="data-table" class="table table-sm">
						<thead class="text-center">
							<tr class="text-center">
								<th scope="col" >Pasaran</th>
								<th scope="col" >Calon Macet Awal</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
								{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
							</tr>
						</thead>
						<tbody>
							@forelse ($kemacetan as $key => $val)
							<tr>
								<td class="text-center"> {{ optional($val->getPasaran)->hari  }} </td>
								<td class="text-right"> {{ $val->cma_saldo  }} </td>
								<td class="text-right"> {{ $val->angsuran ?? 0  }} </td>
								<td class="text-right"> {{ $val->cma_saldo - $val->angsuran  }} </td>
							</tr>
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
			<div class="col-md-12 mt-3">
				<div class="table-responsive">
					<table id="data-table" class="table table-sm">
						<thead class="text-center">
							<tr class="text-center">
								<th scope="col" >Hari Kerja</th>
								<th scope="col" >Calon Macet Awal</th>
								<th scope="col" >Angsuran</th>
								<th scope="col" >Saldo</th>
								{{-- <th scope="col"	rowspan="2">AKSI</th> --}}
							</tr>
						</thead>
						<tbody>
							<tr>
								
								{{-- <td>  </td> --}}
							{{-- <td class="text-center">
							<a class="btn btn-xs btn-info" href="{{   action('KemacetanController@edit', $val->id)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('KemacetanController@delete',$val->id) }}">Hapus</a>
						</td> --}}
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>
<hr>
</div>