	<div class="card card-success card-outline">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12 text-right">
					<a class="btn btn-sm btn-danger modal-button" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('PerkembanganController@setHk') }}?tanggal={{ $request->tanggal }}&cabang={{ $request->cabang }}"  data-toggle="tooltip" data-placement="top"  >Setting Sisa Hari Kerja</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-8">
							<h5>Kalkulasi Kemacetan</h5>
						</div>
						<div class="col-md-4">
							<b>Sisa Hari Kerja : {{ $kemacetan->first()->sisa_hk ?? 0 }}</b>
						</div>
					</div>
					<div class="table-responsive">
						<table id="data-table" class="table table-bordered table-sm">
							<thead class="text-center bg-orange">
								<tr class="text-center">
									<th width="5%">NO.</th>
									<th width="40%">RESORT</th>
									<th width="20%">MACET </th>
									<th width="20%">TARGET / HARI</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($kemacetan as $key => $val)
								<tr class="text-right">
									<td class="text-center"> {{ $loop->index +1 }} </td>
									<td class="text-center"> {{ $val->getResort->nama  }} </td>
									<td> {{ number_format($val->sisa_angsuran)  }} </td>
									<td> {{ number_format($val->target)  }} </td>
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
			</div>			
			<hr style="border-top: 4px solid black;">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-8">
							<h5>Kalkulasi Calon Macet</h5>
						</div>
						<div class="col-md-4">
							<b>Sisa Hari Kerja : {{ $calonMacet->first()->sisa_hk ?? 0 }}</b>
						</div>
					</div>
					<div class="table-responsive">
						<table id="data-table" class="table table-bordered table-sm">
							<thead class="text-center bg-info">
								<tr class="text-center">
									<th width="5%">NO.</th>
									<th width="40%">RESORT</th>
									<th width="20%">CALON MACET </th>
									<th width="20%">TARGET / HARI</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($calonMacet as $key => $val)
								<tr class="text-right">
									<td class="text-center"> {{ $loop->index +1 }} </td>
									<td class="text-center"> {{ $val->getResort->nama  }} </td>
									<td> {{ number_format($val->sisa_angsuran)  }} </td>
									<td> {{ number_format($val->target)  }} </td>
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
			</div>
		</div><!-- /.card-body -->
		<hr>
	</div>