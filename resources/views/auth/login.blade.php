@extends('layouts.app_auth')
@section('title','Login')
@section('content')
<div class="login-box">
	<div class="login-logo">
		<h4 ><a href="{{ url('/') }}" style="color: white">Sistem Informasi Perkembangan Perusahaan</a></h4>
	</div>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body">
			<form method="POST" action="{{ route('login') }}" class="">
				<label for="email" class="col-md-12 col-form-label">{{ __('E-Mail') }}</label>
				<div class="input-group mb-3">
					@csrf
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
					@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror

				</div>
				<label for="email" class="col-md-12 col-form-label">{{ __('Password') }}</label>
				<div class="input-group mb-3">
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
					@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="row">
					<!-- /.col -->
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block">Login</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
{{-- 
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
    </p> --}}
</div>
<!-- /.login-card-body -->
</div>
</div>
<!-- /.login-box -->
@endsection