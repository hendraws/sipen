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
						<th scope="col" >NO.</th>
						<th scope="col" >PASARAN</th>
						<th scope="col" >TARGET</th>
						<th scope="col" ></th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr class="text-center">
						<td> {{ $loop->index +1 }} </td>
						<td> {{ $val->getPasaran->hari  }} </td>
						<td> {{ $val->target_lalu  }}</td>
						<td class="text-center">
							
							<a class="btn btn-xs btn-info modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('TargetLaluController@edit',$val) }}">Edit</a>
							<a class="btn btn-xs btn-danger hapus ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('TargetLaluController@destroy',$val) }}">Hapus</a>
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