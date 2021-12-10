<form action="{{ action('TargetLaluController@update', $Target_lalu) }}" method="POST" id="kantorCabangForm">
	<div class="modal-header ">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		@csrf
		@method('put')
		<div class="form-group row">
			<label for="resort" class="col-sm-2 col-form-label">Resort</label>
			<div class="col-md-10">
				<input type="text"  class="form-control" value="{{ $Target_lalu->getResort->nama }}" disabled readonly>
			</div>
		</div>		
		<div class="form-group row">
			<label for="pasaran" class="col-sm-2 col-form-label">Pasaran</label>
			<div class="col-md-10">
				<input type="text"  class="form-control" value="{{ $Target_lalu->getPasaran->hari }}" disabled="" readonly="">
			</div>
		</div>		
		<div class="form-group row">
			<label for="target_lalu" class="col-sm-2 col-form-label">Jumlah Anggota</label>
			<div class="col-md-10">
				<input type="number" id="target_lalu" class="form-control" name="target_lalu" value="{{ $Target_lalu->target_lalu }}">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>

	</div>
</form>