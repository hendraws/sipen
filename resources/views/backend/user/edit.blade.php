@extends('layouts.app_master')
@section('title', 'Management User')
@section('content-title', 'Management User')
@section('content')
<div class="card card-primary card-outline">
	<div class="card-header row">
		Edit Data {{ $data->name }}
	</div>
	<div class="card-body">
		<form action="{{ action('UserController@update', $data->id) }}" method="POST" id="kantorCabangForm">
			@csrf
			@method('PUT')
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Nama</label>
				<div class="col-sm-9">
					<input required type="text" class="form-control @error('username') is-invalid @enderror" id="nama" name="username" value="{{ $data->name }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
				<div class="col-sm-9">
					<input required type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $data->email }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Password</label>
				<div class="col-sm-9">
					<input  type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="">
				</div>
			</div>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Konfirmasi Password</label>
				<div class="col-sm-9">
					<input  type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" value="" name="password_confirmation">
				</div>
			</div>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Cabang</label>
				<div class="col-sm-9">
					<select class="form-control custom-select" id="cabang" name="cabang">
						<option selected="" disabled="">Pilih Cabang</option>
						@foreach ($cabang as $key => $val)
						<option value="{{ $key }}" {{ $data->cabang_id == $key ? 'selected' : '' }}>{{ $val }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">Role</label>
				<div class="col-sm-9">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="role" id="role1" value="admin" {{ $data->getRoleNames()->first() == 'admin' ? 'checked' : '' }}>
						<label class="form-check-label" for="role1">Admin</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="role" id="role2" value="user" {{ $data->getRoleNames()->first() == 'user' ? 'checked' : '' }}>
						<label class="form-check-label" for="role2">User</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-secondary" href="{{ action('UserController@index') }}">Kembali</a>
				<button class="btn btn-brand btn-square btn-primary">Simpan</button>
			</div>
		</form>
	</div>
</div>

@endsection


