<form action="{{ action('KantorCabangController@update', $data->id) }}" method="POST" id="kantorCabangForm">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">{{ $title_modal }}</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		@csrf
		@method('PUT')
		<div class="form-group row">
			<label for="cabang" class="col-sm-4 col-form-label">Kantor Cabang</label>
			<div class="col-sm-12">
				<input required type="text" class="form-control" id="cabang" value="{{ $data->cabang }}" name="cabang">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button class="btn btn-brand btn-square btn-primary">Simpan</button>

	</div>
</form>