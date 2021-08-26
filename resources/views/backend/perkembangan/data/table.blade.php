<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h4>Bulan : {{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h4>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm">
				<thead>
					<tr>
						<th scope="col">HARI KERJA</th>
						<th scope="col">DROP</th>
						<th scope="col">STORTING</th>
						<th scope="col">TKP</th>
						<th scope="col">PSP</th>
						<th scope="col">DROP TUNDA</th>
						<th scope="col">STORTING TUNDA</th>
						<th scope="col">AKSI</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
						<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->format('d') }}</td>
						<td>{{ number_format($val->drops) }}</td>
						<td>{{ number_format($val->storting) }}</td>
						<td>{{ number_format($val->tkp) }}</td>
						<td>{{ number_format($val->psp) }}</td>
						<td>{{ number_format($val->drop_tunda) }}</td>
						<td>{{ number_format($val->storting_tunda) }}</td>
						<td class="text-center">
							<a class="btn btn-xs btn-warning" href="{{   action('PerkembanganController@edit', $val->id)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('PerkembanganController@delete',$val->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Reset</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="8" class="text-center bg-secondary"><h5>Tidak Ada Data</h5>	</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
	<hr>
	<div class="card-footer">
		<div class="row">
			<div class="col-md-12">
				Total berjalan
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-sm">
				<thead>
					<tr>
						<th scope="col">HARI KERJA</th>
						<th scope="col">DROP</th>
						<th scope="col">STORTING</th>
						<th scope="col">PSP</th>
						<th scope="col">DROP TUNDA</th>
						<th scope="col">STORTING TUNDA</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td scope="col">{{ $globalData->hari_ke }}</td>
						<td scope="col">{{ number_format($globalData->sum_drop) }}</td>
						<td scope="col">{{ number_format($globalData->sum_storting) }}</td>
						<td scope="col">{{ number_format($globalData->sum_psp) }}</td>
						<td scope="col">{{ number_format($globalData->sum_drop_tunda) }}</td>
						<td scope="col">{{ number_format($globalData->sum_storting_tunda) }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>