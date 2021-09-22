		<form action="{{ action('CalonMacetController@store') }}" method="POST" id="kemacetanForm">
			@csrf
			<div class="form-group row">
				<label for="resort" class="col-sm-2 col-form-label">Resort</label>
				<div class="col-md-10">
					<select class="form-control" name="resort_id">
						<option disabled="" selected>Pilih Resort</option>
						@foreach ($resort as $row)
							<option value="{{ $row->id }}" >{{ $row->nama }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<h5>Calon Macet</h5>
			<div class="form-group row">
				<label for="pasaran" class="col-sm-2 col-form-label">Set Pasaran</label>
				<div class="col-md-10">
					<select class="form-control" name="pasaran">
						<option value="1">Senin - Kamis</option>
						<option value="2">Selasa - Jum'at</option>
						<option value="3">Rabu - Sabtu</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_anggota" class="col-sm-2 col-form-label">Jumlah Anggota</label>
				<div class="col-md-10">
					<input type="number" id="ma_anggota" class="form-control" name="cma_anggota">
				</div>
			</div>
			<div class="form-group row">
				<label for="pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="pinjaman" class="form-control hitung" name="cma_pinjaman">
				</div>
			</div>
			<div class="form-group row">
				<label for="target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="target" class="form-control hitung" name="cma_target" readonly="">
				</div>
			</div>
			<div class="form-group row">
				<label for="saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="saldo" class="form-control" name="cma_saldo" readonly="">
				</div>
			</div>
			<hr>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>