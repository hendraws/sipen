{{-- <h5>Angsuran Kemacetan Cabang {{ ucfirst(optional(optional(auth()->user())->getCabang)->cabang) }}</h5> --}}
<form action="{{ action('TargetController@store') }}" method="POST">
	@csrf
	<div class="form-group row">
		<label for="resort" class="col-sm-2 col-form-label">Resort</label>
		<div class="col-md-10">
			<select class="form-control" name="resort_id" required>
				<option disabled selected>Pilih Resort</option>
				@foreach ($resort as $row)
				<option value="{{ $row->id }}" >{{ $row->nama }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
		<div class="col-md-10">
			<input required type="text" id="tanggal" class="form-control tanggal" name="tanggal"  autocomplete="off" value="{{ $today }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="drop" class="col-sm-2 col-form-label">Drop</label>
		<div class="col-md-10">
			<input  required type="number" id="drop" class="form-control hitung" name="target_drops">
		</div>
	</div>
	<div class="form-group row">
		<label for="storting" class="col-sm-2 col-form-label">Storting</label>
		<div class="col-md-10">
			<input  required type="number" id="storting" class="form-control hitung" name="storting_kini">
		</div>
	</div>	
	<div class="form-group row">
		<label for="pelunasan" class="col-sm-2 col-form-label">Pelunasan</label>
		<div class="col-md-10">
			<input  required type="number" id="pelunasan" class="form-control hitung" name="target_plnsn">
		</div>
	</div>
	<div class="form-group row">
		<label for="anggota_lama" class="col-sm-2 col-form-label">Anggota Lama</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_lama" class="form-control" name="anggota_lama">
		</div>
	</div>	
	<div class="form-group row">
		<label for="anggota_baru" class="col-sm-2 col-form-label">Anggota Baru</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_baru" class="form-control" name="anggota_baru">
		</div>
	</div>	
	<div class="form-group row">
		<label for="anggota_keluar" class="col-sm-2 col-form-label">Anggota Keluar</label>
		<div class="col-md-10">
			<input required type="number" id="anggota_keluar" class="form-control" name="anggota_out">
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
		<a href="{{ action('ProgramKerjaController@index') }}" class="btn btn-secondary">Kembali</a>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>
	</div>
</form>