<h5>Angsuran Kemacetan Cabang {{ ucfirst(optional(optional(auth()->user())->getCabang)->cabang) }}</h5>
<form action="{{ action('AngsuranCalonMacetController@store') }}" method="POST">
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
		<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
		<div class="col-md-10">
			<input type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="{{ $today }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="pinjaman" class="col-sm-2 col-form-label">Angsuran</label>
		<div class="col-md-10">
			<input type="number" id="pinjaman" class="form-control hitung" name="angsuran">
		</div>
	</div>
	<div class="form-group row">
		<label for="ma_anggota" class="col-sm-2 col-form-label">Anggota Keluar</label>
		<div class="col-md-10">
			<input type="number" id="ma_anggota" class="form-control" name="anggota_keluar">
		</div>
	</div>
	<div class="form-group row">
		<label for="pasaran" class="col-sm-2 col-form-label">Pasaran</label>
		<div class="col-md-10">
			<select class="form-control" name="pasaran" readonly id="pasaran">
				@foreach($pasaran as $k => $v)
					<option value="{{ $k }}" selected>{{ $v }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<hr>
	<div class="modal-footer">
		<a href="{{ action('AngsuranCalonMacetController@index') }}" class="btn btn-secondary">Kembali</a>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>
	</div>
</form>
<script type="text/javascript">

</script>