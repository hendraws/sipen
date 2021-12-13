		<form action="{{ action('PerkembanganController@store') }}" method="POST" id="kantorCabangForm">
			@csrf
			<div class="form-group row">
				<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
				<div class="col-md-10">
					<input type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="{{ $today }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop" class="col-sm-2 col-form-label">Drop</label>
				<div class="col-md-10">
					<input type="number" id="drop" class="form-control" name="drop">
				</div>
			</div>
			<div class="form-group row">
				<label for="storting" class="col-sm-2 col-form-label">Storting</label>
				<div class="col-md-10">
					<input type="number" id="storting" class="form-control hitung" name="storting">
				</div>
			</div>
			<div class="form-group row">
				<label for="psp" class="col-sm-2 col-form-label">PSP</label>
				<div class="col-md-10">
					<input type="number" id="psp" class="form-control hitung" name="psp">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop_tunda" class="col-sm-2 col-form-label">Drop Tunda Masuk</label>
				<div class="col-md-10">
					<input type="number" id="drop_tunda" class="form-control" name="drop_tunda_masuk">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop_tunda" class="col-sm-2 col-form-label">Drop Tunda Keluar</label>
				<div class="col-md-10">
					<input type="number" id="drop_tunda" class="form-control" name="drop_tunda keluar">
				</div>
			</div>
			<div class="form-group row">
				<label for="drop_tunda" class="col-sm-2 col-form-label">Angsuran Tunda Masuk</label>
				<div class="col-md-10">
					<input type="number" id="drop_tunda" class="form-control" name="angsuran_tunda_masuk">
				</div>
			</div>
				<div class="form-group row">
				<label for="drop_tunda" class="col-sm-2 col-form-label">Angsuran Tunda Keluar</label>
				<div class="col-md-10">
					<input type="number" id="drop_tunda" class="form-control" name="angsuran_tunda_keluar">
				</div>
			</div>
			<div class="form-group row">
				<label for="tkp" class="col-sm-2 col-form-label">TKP</label>
				<div class="col-md-10">
					<input type="number" id="tkp" class="form-control bg-white" name="tkp" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label for="sisa_kas" class="col-sm-2 col-form-label">Sisa Kas</label>
				<div class="col-md-10">
					<input type="number" id="sisa_kas" class="form-control" name="sisa_kas">
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>

			</div>
		</form>