		<form action="{{ action('AnggotaLaluController@store') }}" method="POST" id="kemacetanForm">
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
					<input type="number" id="ma_anggota" class="form-control" name="anggota">
				</div>
			</div>
			<div class="modal-footer">
				<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>