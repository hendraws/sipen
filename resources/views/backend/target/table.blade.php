<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h4>Bulan : {{date_format(date_create_from_format('Y/m/d', $getTanggal), 'F Y')}}</h4>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						<th scope="col" rowspan="2" class="align-middle">No.</th>
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="5">Anggota</th>
						<th scope="col" colspan="4">Target Harian</th>
					</tr>
					<tr class="text-center">
						<th scope="col" >Lalu</th>
						<th scope="col" >Lama</th>
						<th scope="col" >Baru</th>
						<th scope="col" >Out</th>
						<th scope="col" >Kini</th>
						<th scope="col" >Lalu</th>
						<th scope="col" >20% Drop</th>
						<th scope="col" >20% Plsn</th>
						<th scope="col" >Kini</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					<tr>
							<td class="text-center">{{ $loop->index + 1 }}</td>
							<td>{{ $val->getResort->nama }}</td>
							<td>{{ $val->anggota_lalu }}</td>
							<td>{{ $val->anggota_lama }}</td>
							<td>{{ $val->anggota_baru }}</td>
							<td>{{ $val->anggota_out }}</td>
							<td>{{ $val->anggota_kini }}</td>
							<td>{{ $val->target_lalu }}</td>
							<td>{{ $val->target_20_drop }}</td>
							<td>{{ $val->target_20_plnsn }}</td>
							<td>{{ $val->target_kini }}</td>
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
</div>