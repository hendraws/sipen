<form action="{{ action('PerkembanganController@storeHk') }}" method="POST" id="kantorCabangForm">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Set Sisa Hari Kerja</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		@csrf
		<div class="form-group row">
			<label for="cabang" class="col-sm-4 col-form-label">Set Sisa Hari Kerja</label>
			<div class="col-sm-12">
				<input required type="number" autocomplete="off" class="form-control" id="sisa_hk" value="" name="sisa_hk">
			</div>
			<input type="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
			<input type="hidden" name="cabang" value="{{ $data['cabang'] }}">
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>
	</div>
</form>