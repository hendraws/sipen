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
				<th>No</th>
				<th>Cabang</th>
				<th>Bulan</th>
				<th>Drop</th>
				<th>Storting</th>
				<th>TKP</th>
				<th>Drop Tunda</th>
				<th>Storting Tunda</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $key => $val)
			<tr>
				<th>{{ $key+1 }}</th>
				<td>{{ $val->Cabang->cabang }}</td>
				<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal)->format('F') }}</td>
				<td>{{ number_format($val->drops) }}</td>
				<td>{{ number_format($val->storting) }}</td>
				<td>{{ number_format($val->tkp) }}</td>
				<td>{{ number_format($val->drop_tunda) }}</td>
				<td>{{ number_format($val->storting_tunda) }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>