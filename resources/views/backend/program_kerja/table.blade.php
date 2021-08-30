	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h4>Bulan : {{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h4>
			</div>
		</div>
		<div class="table-responsive data-table">
			<table id="data-table" class="table table-bordered table-striped table-sm">
				<thead>
					<tr>
						<th rowspan="2" class="text-center">No</th>
						<th rowspan="2">Kantor Cabang</th>
						<th colspan="5">Program Kerja</th>
						<th rowspan="2">Aksi</th>
					</tr>
					<tr>
						<th>Drop</th>
						<th>Storting</th>
						<th>TKP</th>
						<th>Drop Tunda</th>
						<th>Storting Tunda</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
						<td>{{ $key+1 }}</td>
						<td class="text-left">{{ optional($val->Cabang)->cabang }}</td>
						<td>{{ number_format($val->drops) }}</td>
						<td>{{ number_format($val->storting) }}</td>
						<td>{{ number_format($val->tkp) }}</td>
						<td>{{ number_format($val->drop_tunda) }}</td>
						<td>{{ number_format($val->storting_tunda) }}</td>
						<td class="text-center">
							<a class="btn btn-xs btn-warning" href="{{   action('ProgramKerjaController@edit', $val->id)   }}" >Edit</a>
							<a class="btn btn-xs btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('ProgramKerjaController@delete',$val->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Reset</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="8" class="text-center">Tidak Ada Data</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>		
	</div>
	<div class="card-footer">
		<table class="table table-bordered table-striped table-sm">
			<tr>
				<th colspan="2" rowspan="2" style="		vertical-align: middle;">Rencana Kerja Global</th>
				<th>Drop</th>
				<th>Storting</th>
				<th>TKP</th>
				<th>Drop Tunda</th>
				<th>Storting Tunda</th>
			</tr>
			<tr>
				<td>{{ number_format($globalData->sum_drop) }}</td>
				<td>{{ number_format($globalData->sum_storting) }}</td>
				<td>{{ number_format($globalData->sum_tkp) }}</td>
				<td>{{ number_format($globalData->sum_drop_tunda) }}</td>
				<td>{{ number_format($globalData->sum_storting_tunda) }}</td>
			</tr>
		</table>

	</div>