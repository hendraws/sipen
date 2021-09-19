<form action="{{ action('ResortController@destroy', $resort) }}" method="POST" id="kantorCabangForm">
	<div class="modal-header ">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		@csrf
		@method('DELETE')
		<div class="form-group row">
			<div class="col-md-12 text-center">
				<h3 class="text-center bg-red"><b>PERHATIAN !!!</b></h3>
				<hr>
				<h5>
					APAKAH ANDA YAKIN AKAN MENGHAPUS RESORT {{ strtoupper($resort->name) }} ?
				</h5>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary m-auto col-md-5" data-dismiss="modal">Tidak</button>
		<button class="btn btn-brand btn-square btn-danger m-auto col-md-5">Ya,Hapus</button>

	</div>
</form>