<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.min.css')}}">
	<title>Cetak</title>
	<script type="text/javascript">
		window.print();
	</script>
</head>
<body>
	<div class="row my-5">
		<div class="col-md-12 text-center">
			<h3>Data Kantor Cabang</h3>
		</div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th scope="col">Hari Ke</th>
				<th scope="col">Bulan</th>
				<th scope="col">Drop</th>
				<th scope="col">Storting</th>
				<th scope="col">TKP</th>
				<th scope="col">PSP</th>
				<th scope="col">Drop Tunda</th>
				<th scope="col">Storting Tunda</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $key => $val)
			<tr>
				<th>{{ number_format($val->hari) }}</th>
				<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->format('F')  }}</td>
				<th>{{ number_format($val->drops) }}</th>
				<th>{{ number_format($val->storting) }}</th>
				<th>{{ number_format($val->tkp) }}</th>
				<th>{{ number_format($val->psp) }}</th>
				<th>{{ number_format($val->drop_tunda) }}</th>
				<th>{{ number_format($val->storting_tunda) }}</th>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>