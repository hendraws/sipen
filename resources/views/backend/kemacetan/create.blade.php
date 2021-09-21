		<form action="{{ action('KemacetanController@store') }}" method="POST" id="kemacetanForm">
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
			<h5>Macet Awal</h5>
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
					<input type="number" id="ma_anggota" class="form-control" name="ma_anggota">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="ma_pinjaman" class="form-control hitung" name="ma_pinjaman">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="ma_target" class="form-control hitung" name="ma_target">
				</div>
			</div>
			<div class="form-group row">
				<label for="ma_saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="ma_saldo" class="form-control" name="ma_saldo">
				</div>
			</div>
			<hr>
			<h5>Macet Baru</h5>
			<div class="form-group row">
				<label for="mb_anggota" class="col-sm-2 col-form-label">Anggota</label>
				<div class="col-md-10">
					<input type="number" id="mb_anggota" class="form-control" name="mb_anggota">
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_pinjaman" class="col-sm-2 col-form-label">Pinjaman</label>
				<div class="col-md-10">
					<input type="number" id="mb_pinjaman" class="form-control hitung" name="mb_pinjaman">
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_target" class="col-sm-2 col-form-label">Target</label>
				<div class="col-md-10">
					<input type="number" id="mb_target" class="form-control hitung" name="mb_target">
				</div>
			</div>
			<div class="form-group row">
				<label for="mb_saldo" class="col-sm-2 col-form-label">Saldo</label>
				<div class="col-md-10">
					<input type="number" id="mb_saldo" class="form-control" name="mb_saldo">
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>